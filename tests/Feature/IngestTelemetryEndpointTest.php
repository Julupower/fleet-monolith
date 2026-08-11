<?php

declare(strict_types=1);

use Src\Domain\Fleet\Models\Vehicle;

it('ingests telemetry data successfully via the HTTP endpoint', function () {
    // Arrange: Create a target vehicle record in the database
    $vehicle = Vehicle::create([
        'license_plate' => 'XY51 ABC',
        'make'          => 'Volvo',
        'model'         => 'FH16',
        'status'        => 'active',
    ]);

    $payload = [
        'vehicle_id' => $vehicle->id,
        'latitude'   => 51.5074,
        'longitude'  => -0.1278,
        'speed'      => 65,
    ];

    // Act: Send a POST request to the API endpoint
    $response = $this->postJson('/api/telemetry', $payload);

    // Assert: Verify HTTP status, payload structure, and database persistence
    $response->assertStatus(201)
        ->assertJsonFragment([
            'message' => 'Telemetry record created successfully.',
        ]);

    $this->assertDatabaseHas('telemetries', [
        'vehicle_id' => $vehicle->id,
        'speed'      => 65,
    ]);
});