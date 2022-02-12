<?php

namespace Mariojgt\Castle;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Mariojgt\Castle\Commands\Install;
use Illuminate\Support\ServiceProvider;
use Mariojgt\Castle\Commands\Republish;
use Mariojgt\Castle\Events\UserVerifyEvent;
use Mariojgt\Castle\Listeners\LogoutListener;
use Mariojgt\Castle\Listeners\SendUserVerifyListener;

class CastleProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Event for when you create a new user
        Event::listen(
            UserVerifyEvent::class,
            [SendUserVerifyListener::class, 'handle']
        );

        // On system logout event
        Event::listen(
            Logout::class,
            [LogoutListener::class, 'handle']
        );

        // Load some commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Republish::class,
                Install::class,
            ]);
        }

        // Loading Custom middlewhere
        // use this middlewhere as the following 2fa:admin
        // 2fa is middlewhere, admin is guard example
        $this->app['router']->aliasMiddleware(
            '2fa', // Name we need to use for this middlewhere
            \Mariojgt\Castle\Middleware\CastleWall::class
        );

        // Load Castle views
        $this->loadViewsFrom(__DIR__ . '/views', 'Castle');

        // Load Castle routes
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        // Hide or display the demo route
        if (config('castle.demo_enable')) {
            $this->loadRoutesFrom(__DIR__ . '/Routes/2stepsDemo.php');
            $this->loadRoutesFrom(__DIR__ . '/Routes/emailVerificationDemo.php');
        }

        // Load Migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publish();
    }

    public function publish()
    {
        // Publish the npm
        $this->publishes([
            __DIR__ . '/../Publish/Npm/' => base_path(),
        ]);

        // Publish the resource
        $this->publishes([
            __DIR__ . '/../Publish/Resource/' => resource_path('vendor/Castle/'),
        ]);

        // Publish the public folder with the css and javascript pre compile
        $this->publishes([
            __DIR__ . '/../Publish/Public/' => public_path('vendor/Castle/'),
        ]);

        // Publish the public folder
        $this->publishes([
            __DIR__ . '/../Publish/Config/' => config_path('/'),
        ]);

        // Publish the helper so any other user can change the autentication page
        $this->publishes([
            __DIR__ . '/../Publish/Helper/' => app_path('Helpers/'),
        ]);
    }
}
