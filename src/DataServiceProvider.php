<?php

namespace Veloxia\Data;

use Veloxia\Data\Client;
use Illuminate\Support\ServiceProvider;
use Veloxia\Data\Contracts\DataContract;

class DataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            # Publish config in the /config directory.
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('data.php'),
            ], 'config');

            # Register commands.
            $this->commands([
                \Veloxia\Data\Commands\MakeGraphCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {

        $app = $this->app;

        # Merge package config with published config.
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'data');

        # Register the main application class.
        $this->app->singleton('data', function () use ($app) {
            return new Client($app['config']['data']);
        });

        # Register aliases
        $this->app->alias('data', DataContract::class);
    }
}
