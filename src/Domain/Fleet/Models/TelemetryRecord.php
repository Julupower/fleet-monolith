<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TelemetryRecord extends Model
{
    protected $table = 'telemetry_records';

    public $timestamps = false;

    protected $fillable = [
        'vehicle_id',
        'latitude',
        'longitude',
        'speed',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'integer',
        'recorded_at' => 'datetime',
    ];

    /**
     * Relationship: A telemetry record belongs to a specific vehicle.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}