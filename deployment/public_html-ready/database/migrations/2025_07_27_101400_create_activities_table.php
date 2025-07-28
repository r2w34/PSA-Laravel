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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // student_enrolled, payment_received, attendance_marked, etc.
            $table->text('description');
            $table->foreignId('user_id')->constrained('users');
            $table->unsignedBigInteger('entity_id')->nullable(); // ID of the related entity
            $table->string('entity_type')->nullable(); // student, payment, attendance, etc.
            $table->json('metadata')->nullable(); // Additional data about the activity
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
