<?php

namespace Mariojgt\Castle\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

class WallAutentication extends Controller
{
    public function tryAutentication(Request $request)
    {
        // Get the user typed code
        $request->validate([
            'code'       => 'required',
        ]);

        $autenticatorHandle = new AutenticatorHandle();
        $verification       = $autenticatorHandle->checkCode(Request('code'));

        if ($verification) {
            // Create some varaible so the user can be autenticate and pass the middlewhere
            Session::put('castle_wall_autenticate', true);
            Session::put('castle_wall_last_sync', Carbon::now());

            return redirect()->route(config('castle.sucess_login_route'));
        } else {
            return redirect()->back()->with('error', 'Credentials do not match');
        }
    }
}
