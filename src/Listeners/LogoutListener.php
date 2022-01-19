<?php

namespace Mariojgt\Castle\Listeners;

use Mariojgt\Castle\Helpers\AutenticatorHandle;

class LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * On user logout we trigger this wich is goin to made so the autentication varaibles are reset
     * @return [type]
     */
    public function handle()
    {
        $castleHelperManager = new AutenticatorHandle();
        $castleHelperManager->logout();
    }
}
