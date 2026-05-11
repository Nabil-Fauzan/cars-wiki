<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Comparison Logs (Heatmap)
        Schema::create('comparison_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_a_id')->constrained('cars')->onDelete('cascade');
            $table->foreignId('car_b_id')->constrained('cars')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });

        // 2. Simple Activity Logs (Audit)
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // e.g., 'created', 'updated', 'deleted'
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->json('changes')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });

        // 3. User Feedback Center
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('car_id')->nullable()->constrained()->onDelete('set null');
            $table->string('type'); // e.g., 'data_correction', 'feature_request', 'bug'
            $table->text('message');
            $table->string('status')->default('pending'); // pending, resolved, dismissed
            $table->timestamps();
        });

        // 4. Update Cars table for SEO & Link Check
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('seo_score')->default(0);
            $table->timestamp('last_link_check_at')->nullable();
            $table->boolean('has_broken_links')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comparison_logs');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('feedbacks');
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['seo_score', 'last_link_check_at', 'has_broken_links']);
        });
    }
};
