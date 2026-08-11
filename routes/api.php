<?php

use Illuminate\Support\Facades\Route;
use Src\App\Fleet\Http\Controllers\IngestTelemetryController;

Route::post('/telemetry', IngestTelemetryController::class);