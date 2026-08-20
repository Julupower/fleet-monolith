<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Listeners;

use Illuminate\Support\Facades\Log;
use Src\Domain\Fleet\Events\TelemetryIngested;

final class DetectSpeedingViolation
{
    /**
     * Handle the domain event.
     *
     * @param TelemetryIngested $event
     * @return void
     */
    public function handle(TelemetryIngested $event)
    {
        if ($event->telemetry->speed > 70.0) {
            Log::warning("Speeding violation detected for vehicle: {$event->telemetry->vehicle_id}", [
                'speed'        => $event->telemetry->speed,
                'telemetry_id' => $event->telemetry->id,
            ]);
        }
    }
}