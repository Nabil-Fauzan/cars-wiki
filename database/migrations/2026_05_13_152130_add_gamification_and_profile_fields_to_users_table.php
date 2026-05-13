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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('email');
            $table->boolean('is_public')->default(true)->after('points');
            $table->text('bio')->nullable()->after('is_public');
            $table->string('location')->nullable()->after('bio');
            $table->boolean('price_alerts_enabled')->default(true)->after('location');
            $table->timestamp('last_active_at')->nullable()->after('price_alerts_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['points', 'is_public', 'bio', 'location', 'price_alerts_enabled', 'last_active_at']);
        });
    }
};
