<?php

namespace Mariojgt\Castle\Helpers;

use Carbon\Carbon;
use BaconQrCode\Writer;
use Illuminate\Support\Str;
use App\Helpers\CastleHelper;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Auth;
use Mariojgt\Castle\Model\CastleCode;
use BaconQrCode\Renderer\ImageRenderer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;

/**
 * This class will handle the autenticator 2fa authentication
 */
class AutenticatorHandle
{
    public function __construct()
    {
        // Google autenticator class
        $this->google2fa    = new Google2FA();
        // This is the overide class we goin to use case we need to change the default view location
        $this->castleHelper = new CastleHelper();
    }

    /**
     * Generate the autenticator code and the qrcode string
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
        Session::put('autenticator_key', encrypt($registration_data['google2fa_secret']));

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
     * Validate the autenticator code, this will return true or false
     * @param mixed $one_time_password
     * @param null $key
     *
     * @return [type]
     */
    public function checkCode($one_time_password)
    {
        // Try to get the codes from the guard if not gets from the session
        try {
            $secret        = Auth::guard(Session::get('castle_wall_current_guard'))->user()->getCodes;
            // Check if the user has the autenticator enable else we need to get from the session
            if (empty($secret)) {
                $secretDecrypt = decrypt(Session::get('autenticator_key'));
            } else {
                $secretDecrypt = decrypt($secret->secret);
            }
        } catch (\Throwable $th) {
            $secretDecrypt = decrypt(Session::get('autenticator_key'));
        }

        return $this->google2fa->verifyKey($secretDecrypt, $one_time_password);
    }

    /**
     * When you logout from the aplication call this method so we reset the one time password
     * @return [type]
     */
    public function logout()
    {
        // Forget the autenticator secret
        Session::forget('autenticator_key');
        // Forget the by pass in the middlewhere
        Session::forget('castle_wall_autenticate');
        // also forget the last time sync
        Session::forget('castle_wall_last_sync');
        // Return ture means is logout from the autenticator
        return true;
    }

    /**
     * Createa the need session varaibles so the user can login in the system without the twoStepsVerification
     * @return [type]
     */
    public function login()
    {
        // Create some varaible so the user can be autenticate and pass the middlewhere
        Session::put('castle_wall_autenticate', true); // means the user can pass the middlewhere
        Session::put('castle_wall_last_sync', Carbon::now()); // the last time him did as sync

        return true;
    }

    /**
     * Return the view where the user can autenticate using the autenticator code
     * @return [type]
     */
    public function renderWallAutentication()
    {
        return $this->castleHelper->overrideWallAuthentication();
    }

    /**
     * Generate and return the backupcodes
     *
     * @param mixed $secret
     *
     * @return [array]
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
     * This fuction the user will type his valid backup code and we goin to check so the user
     * can acess the next request
     * @param mixed $code
     *
     * @return [array]
     */
    public function useBackupCode($backupCode, $encryptAutenticatorSecret = null)
    {
        // If empty it comes from the session note that we descypt that before
        if (empty($encryptAutenticatorSecret)) {
            $encryptAutenticatorSecret = Session::get('autenticator_key');
        }

        // Try to find that key backup codes
        $backupCodes = CastleCode::where('secret', $encryptAutenticatorSecret)->first();

        // If not found return false
        if (empty($backupCodes)) {
            return [
                'message' => 'Autenticator code not found.',
                'status'  => false
            ];
        } else {
            // Decode the codes so we can loop through them
            $codes = collect(json_decode($backupCodes->codes));

            foreach ($codes as $key => $code) {
                // Descrypt the database code and compare to the user
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

                        // Login the user because at this poin the code is valid
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
     * This method will remove the twosetps verification for the user
     * @param Model $model
     *
     * @return [type]
     */
    public function removeTwoStepsAutenticator(Model $model)
    {
        // Remove the autenticator
        $model->getCodes->delete();
        return true;
    }
}
