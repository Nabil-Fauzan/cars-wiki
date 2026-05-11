<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->string('moderation_status')->default('published')->after('status');
            $table->unsignedInteger('comparison_count')->default(0)->after('moderation_status');
            $table->unsignedInteger('favorite_count')->default(0)->after('comparison_count');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['moderation_status', 'comparison_count', 'favorite_count']);
        });
    }
};
