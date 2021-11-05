<?php

namespace Mariojgt\Castle\Commands;

use Artisan;
use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:castle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will install Castle package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Copy the need file to make the Castle to work
        Artisan::call('vendor:publish', [
            '--provider' => 'Mariojgt\Castle\SkeletonProvider',
            '--force'    => true,
        ]);

        // Copy the need file to make the laravel sanctum work
        Artisan::call('vendor:publish', [
            '--provider' => 'PragmaRX\Google2FALaravel\ServiceProvider',
            '--force'    => true,
        ]);

        // Migrate
        Artisan::call('migrate');
        // Cache the config
        // Artisan::call('config:cache');
        // Cache the views
        // Artisan::call('view:cache');
        // Cache the routes
        // Artisan::call('route:cache');

        $this->newLine();
        $this->info('The command was successful!');
    }
}
