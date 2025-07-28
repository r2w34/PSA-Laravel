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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('sport_id')->constrained('sports');
            $table->foreignId('coach_id')->constrained('coaches');
            $table->json('schedule'); // { days: ['monday', 'wednesday'], time: '6:00 AM - 7:30 AM' }
            $table->integer('max_capacity');
            $table->integer('current_capacity')->default(0);
            $table->enum('skill_level', ['beginner', 'intermediate', 'advanced']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
