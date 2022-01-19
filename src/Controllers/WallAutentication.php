<?php

namespace Mariojgt\Castle\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CastleHelper;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

class WallAutentication extends Controller
{
    /**
     * Try to check if the code is valid if not then redirect back using the helper witch can be updates
     * @param Request $request
     *
     * @return [type]
     */
    public function tryAutentication(Request $request)
    {
        // Make sure is a valid autenticator code type
        $request->validate([
            'code'       => 'required|integer|max:6|min:6',
        ]);

        $castleHelper = new CastleHelper();

        // This will check if the type code is valid
        $autenticatorHandle = new AutenticatorHandle();
        // Check if the code is valid if yes we can redirect the user tho the correct place
        if ($autenticatorHandle->checkCode(Request('code'))) {
            // If the user pass the one time password we can now login using the session
            $autenticatorHandle->login();
            // Redirect to the correct place
            $castleHelper->onAuthenticationSuccess($request);
        } else {
            // Logout the user
            Auth::logout();
            // Remove any session related to the autenticator
            $autenticatorHandle->logout();
            // Else return back with error
            $castleHelper->onAuthenticationError($request);
        }
    }
}
