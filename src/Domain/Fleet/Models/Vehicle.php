<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasUuids;

    protected $table = 'vehicles';

    protected $fillable = [
        'license_plate',
        'make',
        'model',
        'status',
    ];

    /**
     * Relationship: A vehicle has many telemetry logs.
     */
    public function telemetryRecords(): HasMany
    {
        return $this->hasMany(TelemetryRecord::class, 'vehicle_id', 'id');
    }
}