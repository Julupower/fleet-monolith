<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Src\Domain\Fleet\Models\Telemetry;

final class TelemetryIngested
{
    use Dispatchable, SerializesModels;

    /**
     * @var Telemetry
     */
    public $telemetry;

    public function __construct(Telemetry $telemetry)
    {
        $this->telemetry = $telemetry;
    }
}