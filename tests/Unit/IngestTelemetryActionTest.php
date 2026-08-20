<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Src\Domain\Fleet\Actions\IngestTelemetryAction;
use Src\Domain\Fleet\DataTransferObjects\TelemetryData;
use Src\Domain\Fleet\Events\TelemetryIngested;
use Src\Domain\Fleet\Models\Vehicle;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('persists telemetry data into storage and dispatches TelemetryIngested event', function () {
    // Arrange: Fake events and create a test vehicle record
    Event::fake();

    $vehicle = Vehicle::create([
        'license_plate' => 'AB12 CDE',
        'make'          => 'Ford',
        'model'         => 'Transit',
    ]);

    $dto = new TelemetryData(
        $vehicle->id,
        51.5074,
        -0.1278,
        85
    );

    // Act: Execute the domain action
    $action = new IngestTelemetryAction();
    $telemetry = $action->execute($dto);

    // Assert: Verify database storage and event dispatch
    $this->assertDatabaseHas('telemetries', [
        'id'         => $telemetry->id,
        'vehicle_id' => $vehicle->id,
        'speed'      => 85,
    ]);

    Event::assertDispatched(TelemetryIngested::class, function (TelemetryIngested $event) use ($telemetry) {
        return $event->telemetry->id === $telemetry->id;
    });
});