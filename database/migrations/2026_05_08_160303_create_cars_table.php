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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model_id')->unique();
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->integer('hp')->nullable();
            $table->string('category')->nullable();
            $table->string('transmission')->nullable();
            $table->string('drivetrain')->nullable();
            $table->string('engine')->nullable();
            $table->string('torque')->nullable();
            $table->float('zero_to_sixty')->nullable();
            $table->integer('top_speed')->nullable();
            $table->float('aerodynamics')->nullable();
            $table->integer('braking')->nullable();
            $table->text('history')->nullable();
            $table->text('image_url')->nullable();
            $table->json('gallery')->nullable();
            $table->json('pros')->nullable();
            $table->json('cons')->nullable();
            $table->string('status')->default('Live');
            $table->integer('data_completion')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
