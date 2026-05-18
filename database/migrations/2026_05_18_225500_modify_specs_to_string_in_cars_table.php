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
        Schema::table('cars', function (Blueprint $table) {
            $table->string('zero_to_sixty')->nullable()->change();
            $table->string('top_speed')->nullable()->change();
            $table->string('aerodynamics')->nullable()->change();
            $table->string('braking')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->float('zero_to_sixty')->nullable()->change();
            $table->integer('top_speed')->nullable()->change();
            $table->float('aerodynamics')->nullable()->change();
            $table->integer('braking')->nullable()->change();
        });
    }
};
