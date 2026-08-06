<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Actions;

use Src\Domain\Fleet\DataTransferObjects\TelemetryData;
use Src\Domain\Fleet\Models\Telemetry;

final class IngestTelemetryAction
{
    /**
     * Execute the business operation to persist telemetry data.
     */
    public function execute(TelemetryData $data): Telemetry
    {
        return Telemetry::create($data->toArray());
    }
}