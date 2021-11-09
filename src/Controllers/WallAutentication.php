<?php

namespace Mariojgt\Castle\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        // Make sure is a valid autenticator code type
        $request->validate([
            'code'       => 'required|integer|max:6|min:6',
        ]);

        // This will check if the type code is valid
        $autenticatorHandle = new AutenticatorHandle();
        // Check if the code is valid if yes we can redirect the user tho the correct place
        if ($autenticatorHandle->checkCode(Request('code'))) {
            // Create some varaible so the user can be autenticate and pass the middlewhere
            Session::put('castle_wall_autenticate', true); // means the user can pass the middlewhere
            Session::put('castle_wall_last_sync', Carbon::now()); // the last time him did as sync
            // Return to the next request
            return redirect()->route(config('castle.sucess_login_route'));
        } else {
            // Else return back with error
            return redirect()->back()->with('error', 'Credentials do not match');
        }
    }
}
