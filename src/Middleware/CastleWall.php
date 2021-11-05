<?php

namespace Mariojgt\Castle\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Session;
use Mariojgt\Castle\Helpers\AutenticatorHandle;

/**
 * [This middlewhere will ensure 2 steps verfication]
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
        dd(Auth::guard($guard)->user()->checkAutenticatorSecret());
        // Start the autenticator class handle
        $autenticatorHandle = new AutenticatorHandle();

        // Check if the user is already login if not we need to render a view to make sure it login using the code
        if (empty(Session::get('castle_wall_autenticate'))) {
            return $autenticatorHandle->renderWallAutentication();
        }

        // Now we need to check if the session is expired
        $date = Carbon::parse(Session::get('castle_wall_last_sync'));
        $now  = Carbon::now();
        $diff = $date->diffInMinutes($now);
        // If true we need to make the user autenticate again
        if ($diff >= config('castle.castle_wall_session_time')) {
            return $autenticatorHandle->renderWallAutentication();
        }

        return $next($request);
    }
}
