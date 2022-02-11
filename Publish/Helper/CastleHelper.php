<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * This helper will be use to render the 2fa autentication pages error
 * we can also return a response to the user or a api responce
 */
class CastleHelper
{

    /**
     * This fuction will render the autentication page so the user can type the code
     * note that we can change this to use ajax, inersia js or any other way defult use the blade file
     * @return [type]
     */
    public function overrideWallAuthentication()
    {
        // Render a new request with the autentication page
        return new Response(view('Castle::content.autentication.index'));
    }

    /**
     * On Autentication sucess we redirect the user using the customer helper that you can change
     * @param Request $request
     *
     * @return [type]
     */
    public function onAuthenticationSuccess(Request $request)
    {
        // Return to the next request
        return redirect()->route(config('castle.sucess_login_route'));
    }

    /**
     * On Autentication error we redirect the user using the customer helper that you can change
     * @param Request $request
     *
     * @return [type]
     */
    public function onAuthenticationError(Request $request)
    {
        // Else return back with error
        return redirect()->back()->with('error', 'Credentials do not match');
    }
}
