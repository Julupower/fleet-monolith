<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Log;
use Src\Domain\Fleet\Events\TelemetryIngested;
use Src\Domain\Fleet\Listeners\DetectSpeedingViolation;
use Src\Domain\Fleet\Models\Telemetry;
use Tests\TestCase;

uses(TestCase::class);

it('logs a warning when vehicle speed exceeds 80 km/h', function () {
    Log::spy();

    $telemetry = new Telemetry([
        'vehicle_id' => '01a01f02-4790-723a-ad79-96b032b98173',
        'latitude'   => 51.5074,
        'longitude'  => -0.1278,
        'speed'      => 85,
    ]);

    $event = new TelemetryIngested($telemetry);
    $listener = new DetectSpeedingViolation();

    $listener->handle($event);

    Log::shouldHaveReceived('warning')
        ->once()
        ->with("Vehicle {$telemetry->vehicle_id} exceeded speed limit.", [
            'speed' => 85,
        ]);
});

it('does not log a warning when vehicle speed is within 80 km/h limit', function () {
    Log::spy();

    $telemetry = new Telemetry([
        'vehicle_id' => '01a01f02-4790-723a-ad79-96b032b98173',
        'latitude'   => 51.5074,
        'longitude'  => -0.1278,
        'speed'      => 75,
    ]);

    $event = new TelemetryIngested($telemetry);
    $listener = new DetectSpeedingViolation();

    $listener->handle($event);

    Log::shouldNotHaveReceived('warning');
});