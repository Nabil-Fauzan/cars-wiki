<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_user', function (Blueprint $row) {
            $row->id();
            $row->foreignId('user_id')->constrained()->onDelete('cascade');
            $row->foreignId('car_id')->constrained()->onDelete('cascade');
            $row->timestamps();
            
            $row->unique(['user_id', 'car_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('car_user');
    }
};
