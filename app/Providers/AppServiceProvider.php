<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Src\Domain\Fleet\Events\TelemetryIngested;
use Src\Domain\Fleet\Listeners\DetectSpeedingViolation;

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
        Event::listen(
            TelemetryIngested::class,
            DetectSpeedingViolation::class
        );
    }
}