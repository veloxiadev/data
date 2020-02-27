<?php

namespace Veloxia\Data;

use Illuminate\Support\ServiceProvider;
use Veloxia\Data\Client;

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
                'vd.make.graph' => \Veloxia\Data\Commands\MakeGraphCommand::class,
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
        $app->singleton('data', function ($app) {
            return new Client($this->getConfig($app));
        });
    }

    private function getConfig($app)
    {
        return $app['config']->get('data');
    }
}
