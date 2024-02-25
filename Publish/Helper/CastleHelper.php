<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * This helper will be use to render the 2fa authentication pages error
 * we can also return a response to the user or a api response
 */
class CastleHelper
{

    /**
     * This function will render the authentication page so the user can type the code
     * note that we can change this to use ajax, inertia js or any other way default use the blade file
     * @return [type]
     */
    public function overrideWallAuthentication()
    {
        // Render a new request with the authentication page
        return redirect()->route('castle.wall');
    }

    /**
     * On authentication success we redirect the user using the customer helper that you can change
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
     * On authentication error we redirect the user using the customer helper that you can change
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
