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
            // Engine Sound Library
            $table->string('engine_sound_url')->nullable()->after('image_url');
            
            // Marketplace Insights
            $table->decimal('min_price', 15, 2)->nullable()->after('engine_sound_url');
            $table->decimal('max_price', 15, 2)->nullable()->after('min_price');
            $table->decimal('avg_price', 15, 2)->nullable()->after('max_price');
            $table->string('price_trend')->nullable()->after('avg_price'); // 'up', 'down', 'stable'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['engine_sound_url', 'min_price', 'max_price', 'avg_price', 'price_trend']);
        });
    }
};
