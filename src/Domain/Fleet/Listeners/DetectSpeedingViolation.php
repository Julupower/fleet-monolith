<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Domain\Fleet\Events\TelemetryIngested;

class DetectSpeedingViolation
{
    public function handle(TelemetryIngested $event): void
    {
        if ($event->telemetry->speed > 80) {
            Log::warning("Vehicle {$event->telemetry->vehicle_id} exceeded speed limit.", [
                'speed' => $event->telemetry->speed,
            ]);
        }
    }
}