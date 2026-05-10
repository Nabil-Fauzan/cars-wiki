<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->index('model_id');
            $table->index('make');
            $table->index('status');
            $table->index('category');
            $table->index('year');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropIndex(['model_id']);
            $table->dropIndex(['make']);
            $table->dropIndex(['status']);
            $table->dropIndex(['category']);
            $table->dropIndex(['year']);
        });
    }
};
