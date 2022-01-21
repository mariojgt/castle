<?php

namespace Mariojgt\Castle\Listeners;

use Mariojgt\Castle\Helpers\AutenticatorHandle;
use Mariojgt\Castle\Helpers\EmailAutenticator;

class LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // you can add some more varaible in here
    }

    /**
     * On user logout we trigger this wich is goin to made so the autentication varaibles are reset
     * @return [type]
     */
    public function handle()
    {
        // 2 steps to make the autentication varaibles are reset
        $castleHelperManager = new AutenticatorHandle();
        $castleHelperManager->logout();

        $emailAutenticator = new EmailAutenticator();
        $emailAutenticator->logout();
    }
}
