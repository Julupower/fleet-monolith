<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Src\App\Fleet\Requests\StoreTelemetryRequest;
use Src\Domain\Fleet\DataTransferObjects\TelemetryData;
use Src\Domain\Fleet\Models\Vehicle;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('instantiates a telemetry DTO from validated request data', function () 
{
    // 1. Create a real vehicle in the database so the 'exists' rule passes
    $vehicle = Vehicle::create([
            'license_plate' => 'AB12 CDE',
            'make'          => 'Tesla',
            'model'         => 'Model 3',
            'status'        => 'active',
        ]);

    $payload = [
        'vehicle_id' => $vehicle->id,
        'latitude'   => 51.5074,
        'longitude'  => -0.1278,
        'speed'      => 45,
    ];

    $request = new StoreTelemetryRequest();
    $request->merge($payload);

    // 2. Validate the payload against the request rules
    $validator = Validator::make($payload, $request->rules());
    $validator->validate();
    $request->setValidator($validator);

    // 3. Transform the request into the DTO
    $dto = TelemetryData::fromRequest($request);

    // 4. Assert DTO properties match input values
    expect($dto->vehicleId)->toBe($vehicle->id)
        ->and($dto->latitude)->toBe(51.5074)
        ->and($dto->longitude)->toBe(-0.1278)
        ->and($dto->speed)->toBe(45);
});