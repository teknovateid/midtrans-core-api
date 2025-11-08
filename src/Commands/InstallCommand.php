<?php

namespace MidtransCoreApi\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

class InstallCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'midcore:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Midtrans Core API package';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Installing Midtrans Core API...');


        $this->addRoute();

        // jalankan php artisan vendor:publish --tag=midtrans-config


        $this->info('Midtrans Core API installed successfully.');
    }


    // add route
    protected function addRoute(): void
    {
        if (file_exists(base_path('routes/web.php'))) {
            $webRoutes = file_get_contents(base_path('routes/web.php'));
            $routeToAdd = "if (file_exists(base_path('routes/payment.php'))) {\n    require base_path('routes/payment.php');\n}\n";

            if (strpos($webRoutes, $routeToAdd) === false) {
                file_put_contents(
                    base_path('routes/web.php'),
                    "\n" . $routeToAdd,
                    FILE_APPEND
                );

                if (!file_exists(base_path('routes/payment.php'))) {
                    copy(__DIR__ . '/../../routes/payment.php', base_path('routes/payment.php'));


                }

                $this->info('Midtrans Core API routes added to web.php.');
            } else {
                $this->info('Midtrans Core API routes already exist in web.php.');
            }
        }
    }
}
