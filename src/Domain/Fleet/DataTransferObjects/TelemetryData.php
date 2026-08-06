<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\DataTransferObjects;

use Src\App\Fleet\Requests\StoreTelemetryRequest;

final class TelemetryData
{
    /** @var string */
    public $vehicleId;

    /** @var float */
    public $latitude;

    /** @var float */
    public $longitude;

    /** @var int */
    public $speed;

    public function __construct(
        string $vehicleId,
        float $latitude,
        float $longitude,
        int $speed
    ) {
        $this->vehicleId = $vehicleId;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
        $this->speed     = $speed;
    }

    /**
     * Create a DTO instance directly from a validated Form Request.
     */
    public static function fromRequest(StoreTelemetryRequest $request): self
    {
        return new self(
            (string) $request->validated('vehicle_id'),
            (float) $request->validated('latitude'),
            (float) $request->validated('longitude'),
            (int) $request->validated('speed')
        );
    }

    /**
     * Convert DTO values back into an associative array for persistence.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'vehicle_id' => $this->vehicleId,
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,
            'speed'      => $this->speed,
        ];
    }
}