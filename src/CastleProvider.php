<?php

namespace Mariojgt\Castle;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Mariojgt\Castle\Commands\Install;
use Mariojgt\Castle\Commands\Republish;
use Mariojgt\Castle\Events\UserVerifyEvent;
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

        // Load some commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Republish::class,
                Install::class,
            ]);
        }

        // Loading Custom middlewhere
        $this->app['router']->aliasMiddleware(
            'wall', \Mariojgt\Castle\Middleware\CastleWall::class
        );

        // Load Castle views
        $this->loadViewsFrom(__DIR__.'/views', 'Castle');

        // Load Castle routes
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        // Load Migrations
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
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
            __DIR__.'/../Publish/Npm/' => base_path(),
        ]);

        // Publish the resource
        $this->publishes([
            __DIR__.'/../Publish/Resource/' => resource_path('vendor/Castle/'),
        ]);

        // Publish the public folder with the css and javascript pre compile
        $this->publishes([
            __DIR__.'/../Publish/Public/' => public_path('vendor/Castle/'),
        ]);

        // Publish the public folder
        $this->publishes([
            __DIR__.'/../Publish/Config/' => config_path(''),
        ]);
    }
}
