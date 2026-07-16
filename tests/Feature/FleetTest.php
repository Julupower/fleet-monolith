<?php

declare(strict_types=1);

use Src\Domain\Fleet\Models\Vehicle;
use Src\Domain\Fleet\Models\TelemetryRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can persist a vehicle with automated uuid generation', function () {
    // Act: Create a vehicle without defining an ID manually
    $Vehicle = Vehicle::create([
        'license_plate' => 'AA26 XYZ',
        'make' => 'Tesla',
        'model' => 'Model Y',
        'status' => 'active',
    ]);

    // Assert: Verify database presence and that UUID was dynamically generated
    $this->assertDatabaseHas('vehicles', [
        'license_plate' => 'AA26 XYZ',
    ]);
    
    expect($Vehicle->id)->not->toBeNull()
        ->and(strlen($Vehicle->id))->toBe(36); // standard UUID length format
});

it('can record and retrieve telemetry logs for a vehicle', function () {
    // Arrange: Establish our core asset
    $Vehicle = Vehicle::create([
        'license_plate' => 'BB26 ABC',
        'make' => 'Rivian',
        'model' => 'EDV',
        'status' => 'active',
    ]);

    // Act: Create a linked telemetry entry via the relationship
    $Vehicle->telemetryRecords()->create([
        'latitude' => 51.50740000,
        'longitude' => -0.12780000,
        'speed' => 60,
    ]);

    // Assert: Verify relationship retrieval works perfectly
    expect($Vehicle->telemetryRecords)->toHaveCount(1);
    
    $Record = $Vehicle->telemetryRecords->first();
    expect($Record->speed)->toBe(60)
        ->and($Record->latitude)->toBe(51.5074)
        ->and($Record->longitude)->toBe(-0.1278);
});