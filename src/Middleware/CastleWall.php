<?php

namespace Mariojgt\Castle\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AuthenticatorHandle;

/**
 * [This middleware will ensure 2 steps verification]
 */
class CastleWall
{
    public function __construct(Application $app, Request $request)
    {
        $this->app     = $app;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     * This will check if the user has the permission to manage this.
     * Remember session are generate in the server side
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'web')
    {
        // Make sure that the user is login before we can check the authenticator code
        if (Auth::guard($guard)->check()) {
            // Check if the current user has twoStepsEnable enable if yes we can check
            if (Auth::guard($guard)->user()->twoStepsEnable()) {
                // Start the authenticator class handle
                $AuthenticatorHandle = new AuthenticatorHandle();

                // Check if the user has already pass 2 steps authentication
                if (empty(Session::get('castle_wall_autenticate'))) {
                    // Create the session telling us what is the current guard
                    Session::put('castle_wall_current_guard', $guard);
                    // render the authenticator view where the user need to type the code
                    return $AuthenticatorHandle->renderWallAuthentication();
                }

                // Check if the session can expire
                if (config('castle.castle_session_can_expire')) {
                    // Now we need to check if the session is expired
                    $date = Carbon::parse(Session::get('castle_wall_last_sync'));
                    $now  = Carbon::now();
                    // Check the session difference in minutes
                    $diff = $date->diffInMinutes($now);
                    // If true we need to make the user authenticate again
                    if ($diff >= config('castle.castle_wall_session_time')) {
                        // Render the authenticator view where the user need to type the code
                        return $AuthenticatorHandle->renderWallAuthentication();
                    }
                }
                // Green light to go to the next middleware
                return $next($request);
            } else {
                // Green light to go to the next middleware
                return $next($request);
            }
        } else {
            // Case is not login return a 401
            abort(401);
        }
    }
}
