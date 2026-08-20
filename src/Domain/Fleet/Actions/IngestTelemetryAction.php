<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Actions;

use Src\Domain\Fleet\DataTransferObjects\TelemetryData;
use Src\Domain\Fleet\Events\TelemetryIngested;
use Src\Domain\Fleet\Models\Telemetry;

final class IngestTelemetryAction
{
    public function execute(TelemetryData $data): Telemetry
    {
        $telemetry = Telemetry::create([
            'vehicle_id' => $data->vehicleId,
            'latitude'   => $data->latitude,
            'longitude'  => $data->longitude,
            'speed'      => $data->speed,
        ]);

        TelemetryIngested::dispatch($telemetry);

        return $telemetry;
    }
}