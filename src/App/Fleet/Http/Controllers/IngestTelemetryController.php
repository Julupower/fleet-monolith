<?php

declare(strict_types=1);

namespace Src\App\Fleet\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Src\App\Fleet\Http\Requests\StoreTelemetryRequest;
use Src\Domain\Fleet\Actions\IngestTelemetryAction;
use Src\Domain\Fleet\DataTransferObjects\TelemetryData;
use Symfony\Component\HttpFoundation\Response;

final class IngestTelemetryController
{
    public function __invoke(
        StoreTelemetryRequest $request,
        IngestTelemetryAction $action
    ): JsonResponse {
        $data = TelemetryData::fromRequest($request);

        $telemetry = $action->execute($data);

        return response()->json(
            [
                'message' => 'Telemetry record created successfully.',
                'data'    => $telemetry,
            ],
            Response::HTTP_CREATED
        );
    }
}