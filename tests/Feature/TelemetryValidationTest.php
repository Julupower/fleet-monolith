<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Validator;
use Src\App\Fleet\Http\Requests\StoreTelemetryRequest;
use Src\Domain\Fleet\Models\Vehicle;

it('validates a valid telemetry payload successfully', function () {
    $vehicle = Vehicle::create([
        'license_plate' => 'AB12 CDE',
        'make'          => 'Volvo',
        'model'         => 'FH16',
        'status'        => 'active',
    ]);

    $data = [
        'vehicle_id' => $vehicle->id,
        'latitude'   => 51.5074,
        'longitude'  => -0.1278,
        'speed'      => 65,
    ];

    $request = new StoreTelemetryRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->passes())->toBeTrue();
});

it('rejects invalid telemetry payloads', function (array $payload, string $expectedField) {
    $request = new StoreTelemetryRequest();
    $validator = Validator::make($payload, $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has($expectedField))->toBeTrue();
})->with([
    'missing vehicle_id'   => [['latitude' => 51.5, 'longitude' => -0.1, 'speed' => 50], 'vehicle_id'],
    'non-existent uuid'    => [['vehicle_id' => '00000000-0000-0000-0000-000000000000', 'latitude' => 51.5, 'longitude' => -0.1, 'speed' => 50], 'vehicle_id'],
    'latitude out of range' => [['vehicle_id' => '00000000-0000-0000-0000-000000000000', 'latitude' => 105.0, 'longitude' => -0.1, 'speed' => 50], 'latitude'],
    'negative speed'       => [['vehicle_id' => '00000000-0000-0000-0000-000000000000', 'latitude' => 51.5, 'longitude' => -0.1, 'speed' => -10], 'speed'],
]);