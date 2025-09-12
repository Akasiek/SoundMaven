<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();

        Vite::prefetch(6);

        Inertia::macro('prefetch', function (string|array $urls) {
            if (!request()->inertia()) {
                return $this;
            }

            $this->share('prefetch', [
                ...$this->getShared('prefetch', []),
                ...(array)$urls,
            ]);

            return $this;
        });
    }
}
