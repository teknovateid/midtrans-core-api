<?php

namespace MidtransCoreApi;

use Illuminate\Support\ServiceProvider;
use MidtransCoreApi\Commands\InstallCommand;

class MidtransCoreApiServiceProvider extends ServiceProvider
{

    public function register(): void {}

    public function boot(): void
    {
        $this->registerVendorPublishables();
        $this->commands([
            InstallCommand::class
        ]);
    }


    protected function registerVendorPublishables(): void
    {
        // config
        $this->publishes([
            __DIR__ . '/../config/midtrans.php' => config_path('midtrans.php'),
        ], 'midtrans-config');

        // migrations
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'midtrans-migrations');

        // views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/midtrans-core-api'),
        ], 'midtrans-views');

        // all publishables
        $this->publishes([
            __DIR__ . '/../config/midtrans.php' => config_path('midtrans.php'),
            __DIR__ . '/../resources/views' => resource_path('views/vendor/midtrans-core-api'),
        ], 'teknovate-midtrans');
    }
}
