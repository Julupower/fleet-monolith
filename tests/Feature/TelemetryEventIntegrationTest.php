<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Src\Domain\Fleet\Actions\IngestTelemetryAction;
use Src\Domain\Fleet\DataTransferObjects\TelemetryData;
use Src\Domain\Fleet\Events\TelemetryIngested;
use Src\Domain\Fleet\Listeners\DetectSpeedingViolation;
use Src\Domain\Fleet\Models\Vehicle;

uses(RefreshDatabase::class);

it('attaches the DetectSpeedingViolation listener to the TelemetryIngested event', function () {
    Event::fake([TelemetryIngested::class]);

    Event::assertListening(
        TelemetryIngested::class,
        DetectSpeedingViolation::class
    );
});

it('logs a warning when a speeding telemetry record is saved via the domain action', function () {
    Log::spy();

    $vehicle = Vehicle::create([
        'license_plate' => 'XY55 ZAA',
        'make'          => 'Volvo',
        'model'         => 'FH16',
    ]);

    $dto = new TelemetryData(
        $vehicle->id,
        51.5074,
        -0.1278,
        95
    );

    $action = new IngestTelemetryAction();
    $action->execute($dto);

    Log::shouldHaveReceived('warning')
        ->once()
        ->with("Vehicle {$vehicle->id} exceeded speed limit.", [
            'speed' => 95,
        ]);
});