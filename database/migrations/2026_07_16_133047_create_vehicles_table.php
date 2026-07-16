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
        Schema::create('vehicles', function (Blueprint $Blueprint) {
            // Using UUIDs as primary keys prevents enumeration attacks on our fleet
            $Blueprint->uuid('id')->primary();
            
            $Blueprint->string('license_plate')->unique();
            $Blueprint->string('make');
            $Blueprint->string('model');
            
            // Enum manages the life-cycle of our active fleet assets
            $Blueprint->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            
            $Blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};