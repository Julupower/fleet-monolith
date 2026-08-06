<?php

declare(strict_types=1);

namespace Src\Domain\Fleet\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

final class Telemetry extends Model
{
    use HasUuids;

    protected $guarded = [];
}