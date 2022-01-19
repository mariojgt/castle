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
 * This class will be use to handle the 2 steps autentications
 * [Description AutenticatorHandle]
 */
class EmailAutenticator
{
    public function triggerEmail($email)
    {
        // Generate a randon code
        $code = Str::random(55);
        DB::beginTransaction();

        $email = $email;
        // Delte all the codes for this email
        $this->checkIfEmailAlreadyExist($email);
        // Save in the database
        $emailVerify         = new EmailVerify();
        $emailVerify->email  = $email;
        $emailVerify->secret = $code;
        $emailVerify->save();
        Mail::to($email)->send(new SendVerificationEmail($code));

        DB::commit();
        return true;
    }

    public function checkIfEmailAlreadyExist($email)
    {
        $emailVerify = EmailVerify::where('email', $email)->first();

        if (!empty($emailVerify)) {
            $emailVerify->delete();
        }
    }

    public function validateCode($code)
    {
        $emailVerify = EmailVerify::where('secret', $code)->first();

        // Check if the code is created more than 5 minutes ago
        if (!empty($emailVerify)) {
            if (Carbon::now()->diffInMinutes($emailVerify->created_at) >= 5) {
                $emailVerify->delete();
                return false;
            } else {
                $emailVerify->delete();
                return true;
            }
        } else {
            return false;
        }
    }
}
