<?php

namespace Mariojgt\Castle\Helpers;

use Google2FA;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;

class AutenticatorHandle
{
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

        // Return the generated code
        return [
            'qr_code' => $QR_Image,
            'secret'  => $registration_data['google2fa_secret']
        ];
    }

    public function checkCode($one_time_password, $key = null)
    {
        // If key not pass we get from session
        if (empty($key)) {
            $key = Session::get('autenticator_key');
        }
        return Google2FA::verifyKey($key, $one_time_password);
    }

    public function logout()
    {
        Session::forget('autenticator_key');
        Session::forget('castle_wall_autenticate');
        Session::forget('castle_wall_last_sync');
        return true;
    }

    public function renderWallAutentication()
    {
        return new Response(view('Castle::content.autentication.index'));
    }
}
