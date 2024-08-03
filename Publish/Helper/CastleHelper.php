<?php

namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        // Send to the home page with url query parameter show_wall
        return redirect()->route('home', ['show_wall' => 'true']);
    }

    /**
     * On authentication success we redirect the user using the customer helper that you can change
     * @param Request $request
     *
     * @return [type]
     */
    public function onAuthenticationSuccess(Request $request)
    {
        $lastUrl = Session::get('castle_wall_last_url');
        if ($lastUrl) {
            // Return to the last url
            return redirect($lastUrl)->with('success', 'Code is valid');
        }
        // Return to the next request
        return redirect()->route('home')->with('success', 'Code is valid');
    }

    /**
     * On authentication removed we redirect the user using the customer helper that you can change
     * @param Request $request
     *
     * @return [type]
     */
    public function onAuthenticationRemoved(Request $request)
    {
        $lastUrl = Session::get('castle_wall_last_url');
        if ($lastUrl) {
            // Return to the last url
            return redirect($lastUrl)->with('success', 'Authenticator removed');
        }
        // Return to the next request
        return redirect()->route('home')->with('success', 'Authenticator removed');
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
        return redirect()->route('home', ['show_wall' => true])->with('error', 'Code is invalid');
    }
}
