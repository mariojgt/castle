<?php

namespace Mariojgt\Castle\Listeners;

use Mariojgt\Castle\Helpers\AuthenticatorHandle;
use Mariojgt\Castle\Helpers\EmailAuthenticator;

class LogoutListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // you can add some more variable in here
    }

    /**
     * On user logout we trigger this which is going to made so the authentication variables are reset
     * @return [type]
     */
    public function handle()
    {
        // 2 steps to make the authentication variables are reset
        $castleHelperManager = new AuthenticatorHandle();
        $castleHelperManager->logout();
        // On logout remove he email session
        $EmailAuthenticator = new EmailAuthenticator();
        $EmailAuthenticator->logout();
    }
}
