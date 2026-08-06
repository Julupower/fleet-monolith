<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telemetry_records', function (Blueprint $Blueprint) {
            $Blueprint->id();
            
            // Constrain directly to the vehicles table UUID key
            $Blueprint->foreignUuid('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            // Coordinate precision: 8 decimal places for latitude, 9 for longitude
            $Blueprint->decimal('latitude', 10, 8);
            $Blueprint->decimal('longitude', 11, 8);
            
            // Speed captured in km/h (integer values are standard and highly indexable)
            $Blueprint->unsignedInteger('speed');
            
            $Blueprint->timestamp('recorded_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telemetry_records');
    }
};