<?php

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
        Schema::table('telemetries', function (Blueprint $table) {
            // Change speed column to decimal(5, 2) to store values up to 999.99 with exact precision
            $table->decimal('speed', 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('telemetries', function (Blueprint $table) {
            // Revert back to integer if rolled back
            $table->integer('speed')->change();
        });
    }
};