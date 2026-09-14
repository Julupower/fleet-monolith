<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class IngestTelemetryTest extends TestCase
{
    use RefreshDatabase;

    public function test_telemetry_payload_is_persisted_successfully(): void
    {
        $vehicleId = (string) Str::uuid();

        // Seed a valid vehicle record to satisfy foreign key constraints
        DB::table('vehicles')->insert([
            'id'            => $vehicleId,
            'license_plate' => 'TEST-999',
            'make'          => 'Tesla',
            'model'         => 'Model Y',
            'status'        => 'active',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        $payload = [
		'vehicle_id' => $vehicleId,
		'latitude'   => 51.5074,
		'longitude'  => -0.1278,
		'speed'      => 45,
	    ];

        // Send POST request to the API route
	$response = $this->postJson('/api/telemetry', $payload);

	// Assert response status and database state
	$response->assertCreated(); // Asserts HTTP 201 Created
	$this->assertDatabaseHas('telemetries', [
		'vehicle_id' => $vehicleId,
		'speed'      => 45,
	    ]);
    }
}