<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Vehicle extends Model
{
    use HasUuids;

    protected $guarded = [];

    /**
     * Relationship: Primary domain telemetry collection.
     */
    public function telemetries(): HasMany
    {
        return $this->hasMany(Telemetry::class);
    }

    /**
     * Relationship: Legacy/Feature test telemetry collection.
     */
    public function telemetryRecords(): HasMany
    {
        return $this->hasMany(Telemetry::class, 'vehicle_id', 'id');
    }
}