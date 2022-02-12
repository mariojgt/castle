<?php

namespace Mariojgt\Castle\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\CastleHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

class WallAutentication extends Controller
{
    /**
     * Try to check if the code that the user type will be valid, else return to the same page
     * @param Request $request
     *
     * @return [type]
     */
    public function tryAutentication(Request $request)
    {
        // Make sure the code has 6 digits
        $request->validate([
            'code'       => 'required|digits:6',
        ]);

        $castleHelper = new CastleHelper();

        // This will check if the type code is valid
        $autenticatorHandle = new AutenticatorHandle();
        // Check if the code is valid if yes we can redirect the user tho the correct place
        if ($autenticatorHandle->checkCode(Request('code'))) {
            // If the user pass the one time password we can now login using the session
            $autenticatorHandle->login();
            // Return to the next request
            return $castleHelper->onAuthenticationSuccess($request);
        } else {
            return $castleHelper->onAuthenticationError($request);
        }
    }

    public function tryUseBackupcode(Request $request)
    {
        // Make sure the code has 6 digits
        $request->validate([
            'code'       => 'required',
        ]);

        $castleHelper = new CastleHelper();

        // This will check if the type code is valid
        $autenticatorHandle = new AutenticatorHandle();
        $code               = $autenticatorHandle->useBackupCode(Request('code'));

        // Check if the code is valid if yes we can redirect the user tho the correct place
        if ($code) {
            // Get the currect guard comes from the castle_middleware
            $currentGuard = Session::get('castle_wall_current_guard');
            // Get the currect login user information
            $user = Auth::guard($currentGuard)->user();
            // If the user pass the one time password we can now login using the session
            $autenticatorHandle->login();
            // and now we remove the two steps autenticator
            $autenticatorHandle->removeTwoStepsAutenticator($user);
            // Return to the next request
            return $castleHelper->onAuthenticationSuccess($request);
        } else {
            return $castleHelper->onAuthenticationError($request);
        }
    }
}
