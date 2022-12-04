<?php

namespace Mariojgt\Castle\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CastleHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AuthenticatorHandle;

class WallAuthenticationController extends Controller
{
    /**
     * Try to check if the code that the user type will be valid, else return to the same page
     * @param Request $request
     */
    public function tryAuthentication(Request $request)
    {
        // Make sure the code has 6 digits
        $request->validate([
            'code'       => 'required|digits:6',
        ]);
        // Castle helper
        $castleHelper = new CastleHelper();

        // This will check if the type code is valid
        $AuthenticatorHandle = new AuthenticatorHandle();
        // Check if the code is valid if yes we can redirect the user tho the correct place
        if ($AuthenticatorHandle->checkCode(Request('code'))) {
            // If the user pass the one time password we can now login using the session
            $AuthenticatorHandle->login();
            // Return to the next request
            return $castleHelper->onAuthenticationSuccess($request);
        } else {
            return $castleHelper->onAuthenticationError($request);
        }
    }

    /**
     * Try to unlock the user using the backup code
     *
     * @param Request $request
     */
    public function tryUseBackupCode(Request $request)
    {
        // Make sure the code has 6 digits
        $request->validate([
            'code'       => 'required',
        ]);

        $castleHelper = new CastleHelper();

        // This will check if the type code is valid
        $AuthenticatorHandle = new AuthenticatorHandle();
        $code               = $AuthenticatorHandle->useBackupCode(Request('code'));

        // Check if the code is valid if yes we can redirect the user tho the correct place
        if ($code) {
            // Get the current guard comes from the castle_middleware
            $currentGuard = Session::get('castle_wall_current_guard');
            // Get the current login user information
            $user = Auth::guard($currentGuard)->user();
            // If the user pass the one time password we can now login using the session
            $AuthenticatorHandle->login();
            // and now we remove the two steps authenticator
            $AuthenticatorHandle->removeTwoStepsAuthenticator($user);
            // Return to the next request
            return $castleHelper->onAuthenticationSuccess($request);
        } else {
            return $castleHelper->onAuthenticationError($request);
        }
    }
}
