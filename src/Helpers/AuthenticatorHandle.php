<?php

namespace Mariojgt\Castle\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Mariojgt\Castle\Model\CastleCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use App\Helpers\CastleHelper;

/**
 * This class will handle the authenticator 2fa authentication
 */
class AuthenticatorHandle
{
    public function __construct()
    {
        // Google authenticator class
        $this->google2fa    = new Google2FA();
        // This is the overide class we goin to use case we need to change the default view location
        $this->castleHelper = new CastleHelper();
    }

    /**
     * Generate the authenticator code and the qrcode string
     * @param string $email
     *
     * @return [array]
     */
    public function generateCode($email = "youtemail@email.com")
    {
        // Generate the code using the google2fa library
        $secretKey = $this->google2fa->generateSecretKey();

        // Add the secret key to the registration data
        $registration_data["google2fa_secret"] = $secretKey;
        // Email
        $registration_data['email'] = $email;
        // Generate the QR image. This is the image the user will scan with their app
        // To set up two factor authentication
        // OR Google2FA::getQRCodeInline
        $qrCodeUrl = $this->generateQrCodeSvg($this->google2fa->getQRCodeUrl(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        ));

        // Add the secret to the session
        Session::put('authenticator_key', encrypt($registration_data['google2fa_secret']));

        // Return the generated qr-code and the secret in text format
        return [
            'qr_code'       => $qrCodeUrl,
            'secret'        => $registration_data['google2fa_secret']
        ];
    }

    /**
     * Generate the svg qr-code
     *
     * @param mixed $urlCode
     *
     * @return string [svg]
     */
    private function generateQrCodeSvg($urlCode)
    {
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        return $writer->writeString($urlCode);
    }

    /**
     * Validate the authenticator code, this will return true or false
     * @param mixed $one_time_password
     * @param null $key
     *
     * @return [type]
     */
    public function checkCode($one_time_password, $key = null)
    {
        // If empty it comes from the session note that we descypt that before
        if (empty($key)) {
            $key = decrypt(Session::get('authenticator_key'));
        }

        return $this->google2fa->verifyKey($key, $one_time_password);
    }

    /**
     * When you logout from the aplication call this method so we reset the one time password
     * @return [type]
     */
    public function logout()
    {
        // Forget the authenticator secret
        Session::forget('authenticator_key');
        // Forget the by pass in the middleware
        Session::forget('castle_wall_autenticate');
        // also forget the last time sync
        Session::forget('castle_wall_last_sync');
        // Return ture means is logout from the authenticator
        return true;
    }

    /**
     * Created the need session variables so the user can login in the system without the twoStepsVerification
     */
    public function login()
    {
        // Create some varaible so the user can be authenticate and pass the middleware
        Session::put('castle_wall_autenticate', true); // means the user can pass the middleware
        Session::put('castle_wall_last_sync', Carbon::now()); // the last time him did as sync

        return true;
    }

    /**
     * Return the view where the user can authenticate using the authenticator code
     */
    public function renderWallAuthentication()
    {
        return $this->castleHelper->overrideWallAuthentication();
    }

    /**
     * Generate and return the backup codes
     *
     * @param mixed $secret
     *
     */
    public function generateBackupCodes($secret)
    {
        // Array of backup codes
        $codes = [];
        // Generate the backup codes 10 times means 10 backup codes
        for ($i = 1; $i <= 10; $i++) {
            $codes[$i] = [
                'code' => $secret . '_' . Str::random(10),
                'used' => false
            ];
        }
        // Return the codes
        return [
            'back_up_code' => json_encode($codes),
            'secret'       => $secret,
        ];
    }

    /**
     * This fuction the user will type his valid backup code and we going to check so the user
     * can acess the next request
     * @param mixed $code
     *
     */
    public function useBackupCode($backupCode, $encryptAuthenticatorSecret = null)
    {
        // If empty it comes from the session note that we decrypt that before
        if (empty($encryptAuthenticatorSecret)) {
            $encryptAuthenticatorSecret = Session::get('authenticator_key');
        }

        // Try to find that key backup codes
        $backupCodes = CastleCode::where('secret', $encryptAuthenticatorSecret)->first();

        // If not found return false
        if (empty($backupCodes)) {
            return [
                'message' => 'authenticator code not found.',
                'status'  => false
            ];
        } else {
            // Decode the codes so we can loop through them
            $codes = collect(json_decode($backupCodes->codes));

            foreach ($codes as $key => $code) {
                // Decrypt the database code and compare to the user
                $decodeCode = $code->code;
                // Compare the string that the user type with the one stored in the database
                if ($decodeCode == $backupCode) {
                    if ($code->used == 'true') {
                        return [
                            'message' => 'Code already used',
                            'status'  => false
                        ];
                    } else {
                        // Mark this code as used
                        $codes[$key]->used  = 'true';
                        $backupCodes->codes = json_encode($codes);
                        $backupCodes->save();

                        // Login the user because at this point the code is valid
                        $this->login();
                        return [
                            'message' => 'Valid Code',
                            'status'  => true
                        ];
                    }
                    break;
                }
            }

            return [
                'message' => 'Code not found',
                'status'  => false
            ];
        }
    }

    /**
     * This method will remove the two septs verification for the user
     * @param Model $model
     *
     */
    public function removeTwoStepsAuthenticator(Model $model)
    {
        // Remove the authenticator
        $model->getCodes->delete();
        return true;
    }
}
