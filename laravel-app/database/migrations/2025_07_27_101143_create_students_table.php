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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('student_id')->unique(); // STU001, STU002, etc.
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->json('emergency_contact')->nullable(); // { name, phone, relation }
            $table->text('medical_notes')->nullable();
            $table->foreignId('sport_id')->constrained('sports');
            $table->foreignId('batch_id')->constrained('batches');
            $table->enum('skill_level', ['beginner', 'intermediate', 'advanced']);
            $table->timestamp('joining_date')->useCurrent();
            $table->boolean('is_active')->default(true);
            $table->string('profile_image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
