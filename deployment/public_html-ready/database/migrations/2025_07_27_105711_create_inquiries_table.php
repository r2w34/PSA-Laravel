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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_id')->unique(); // INQ001, INQ002, etc.
            $table->string('full_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->date('inquiry_date');
            $table->foreignId('sport_id')->constrained('sports');
            $table->string('lead_source')->nullable(); // website, referral, walk-in, social_media
            $table->enum('status', ['hot', 'warm', 'cold', 'converted', 'lost'])->default('warm');
            $table->date('follow_up_date')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users'); // Coach assigned
            $table->text('notes')->nullable();
            $table->json('tags')->nullable(); // ['urgent', 'premium', 'returning_customer']
            $table->foreignId('converted_student_id')->nullable()->constrained('students');
            $table->timestamp('converted_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
