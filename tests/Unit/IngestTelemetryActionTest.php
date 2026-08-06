<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Domain\Fleet\Actions\IngestTelemetryAction;
use Src\Domain\Fleet\DataTransferObjects\TelemetryData;
use Src\Domain\Fleet\Models\Telemetry;
use Src\Domain\Fleet\Models\Vehicle;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('persists telemetry data into storage', function () {
    $vehicle = Vehicle::create();

    $data = new TelemetryData(
        $vehicle->id,
        51.5074,
        -0.1278,
        55
    );

    $action = new IngestTelemetryAction();
    $telemetry = $action->execute($data);

    expect($telemetry)->toBeInstanceOf(Telemetry::class)
        ->and($telemetry->vehicle_id)->toBe($vehicle->id)
        ->and((float) $telemetry->latitude)->toBe(51.5074)
        ->and((float) $telemetry->longitude)->toBe(-0.1278)
        ->and((int) $telemetry->speed)->toBe(55);

    $this->assertDatabaseHas('telemetries', [
        'id'         => $telemetry->id,
        'vehicle_id' => $vehicle->id,
        'speed'      => 55,
    ]);
});