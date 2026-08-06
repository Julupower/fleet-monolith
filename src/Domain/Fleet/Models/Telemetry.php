<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Telemetry extends Model
{
    use HasUuids;

    protected $table = 'telemetries';

    protected $guarded = [];

    /**
     * Attribute type casting rules.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
        'speed'     => 'integer',
    ];
}