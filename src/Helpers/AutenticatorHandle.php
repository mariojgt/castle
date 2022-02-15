<?php

namespace Mariojgt\Castle\Helpers;

use Google2FA;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Mariojgt\Castle\Model\CastleCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class AutenticatorHandle
{
    /**
     * Generate the autenticator code and the qrcode string
     * @param string $email
     *
     * @return [type]
     */
    public function generateCode($email = "youtemail@email.com")
    {
        // Initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');
        // Add the secret key to the registration data
        $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
        // Email
        $registration_data['email'] = $email;

        // Generate the QR image. This is the image the user will scan with their app
        // To set up two factor authentication
        // OR Google2FA::getQRCodeInline
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );
        // Add the secret in the session so we can check later
        Session::put('autenticator_key', encrypt($registration_data['google2fa_secret']));

        // Return the generated qr-code and the secret in text format
        return [
            'qr_code'       => $QR_Image,
            'secret'        => $registration_data['google2fa_secret']
        ];
    }

    /**
     * Validate the autenticator code, this will return true or false
     * @param mixed $one_time_password
     * @param null $key
     *
     * @return [type]
     */
    public function checkCode($one_time_password, $key = null)
    {
        // If empty it comes from the session note that we descypt that before
        if (empty($key)) {
            $key = decrypt(Session::get('autenticator_key'));
        }

        // Verify the code
        return Google2FA::verifyKey($key, $one_time_password);
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
        return new Response(view('Castle::content.autentication.index'));
    }

    /**
     * Generate and return the backupcodes
     *
     * @param mixed $secret
     *
     * @return [type]
     */
    public function generateBackupCodes($secret)
    {
        // Array of backup codes
        $codes = [];
        // Generate the backup codes 10 times means 10 backup codes
        for ($i = 1; $i <= 10; $i++) {
            $codes[$i] = [
                'code' => encrypt($secret . '_' . Str::random(10)),
                'used' => false
            ];
        }
        // Return the code and the secret encrypted for extra security
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
     * @return [type]
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
            $codes = json_decode($backupCodes->codes);
            foreach ($codes as $key => $code) {
                // Descrypt the database code and compare to the user
                $decodeCode = decrypt($code->code);
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
        $model->modelItem()->delete();
        return true;
    }
}
