<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Temporarily change to string to allow JSON data
        Schema::table('cars', function (Blueprint $table) {
            $table->string('hp')->nullable()->change();
        });

        // 2. Convert existing integers/strings to JSON format
        $cars = DB::table('cars')->get();
        foreach ($cars as $car) {
            if ($car->hp && !str_starts_with($car->hp, '[')) {
                DB::table('cars')->where('id', $car->id)->update([
                    'hp' => json_encode([(string)$car->hp])
                ]);
            }
        }

        // 3. Finalize as json
        Schema::table('cars', function (Blueprint $table) {
            $table->json('hp')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('hp')->nullable()->change();
        });
    }
};
