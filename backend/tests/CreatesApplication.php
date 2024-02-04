<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use RuntimeException;

trait CreatesApplication
{
    /**
     * Creates the application.
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        if ($app->configurationIsCached()) {
            throw new RuntimeException('The configuration is cached. Please run "php artisan config:clear" before running the tests.');
        }

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
