<?php

namespace Mariojgt\Castle\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Helpers\CastleHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Mariojgt\Castle\Model\CastleCode;
use Mariojgt\Castle\Model\EmailVerify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Mail\SendVerificationEmail;

/**
 * This Class will handle the email autentication
 * [Description EmailAutenticator]
 */
class EmailAutenticator
{
    /**
     * Send the email verification
     * @param mixed $email
     *
     * @return [type]
     */
    public function triggerEmail($email)
    {
        // Generate a randon code
        $code = Str::random(55);
        DB::beginTransaction();

        $email = $email;
        // Delete all the codes for this email
        $this->checkEmailCode($email);
        // Save in the database
        $emailVerify         = new EmailVerify();
        $emailVerify->email  = $email;
        $emailVerify->secret = $code;
        $emailVerify->save();
        Mail::to($email)->send(new SendVerificationEmail($code));

        DB::commit();
        return true;
    }

    /**
     * Check if the email is already in the database if yes then delete it with the code
     * @param mixed $email
     *
     * @return [type]
     */
    public function checkEmailCode($email)
    {
        $emailVerify = EmailVerify::where('email', $email)->first();

        if (!empty($emailVerify)) {
            $emailVerify->delete();
        }
    }

    /**
     * Validate the enter code
     *
     * @param mixed $code
     *
     * @return [type]
     */
    public function validateCode($code)
    {
        $emailVerify = EmailVerify::where('secret', $code)->first();

        // Check if the code is created more than 5 minutes ago
        if (!empty($emailVerify)) {
            // Code expired
            if (Carbon::now()->diffInMinutes($emailVerify->created_at) >= 5) {
                $emailVerify->delete();
                return false;
            } else {
                // Code is valid
                $emailVerify->delete();
                Session::put('castle_email_autenticate', true); // means the user can pass the middlewhere
                return true;
            }
        } else {
            // Code not found
            return false;
        }
    }

    public function logout()
    {
        // Forget the autenticator secret
        Session::forget('castle_email_autenticate');

        return true;
    }
}
