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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique(); // CERT001, CERT002, etc.
            $table->foreignId('student_id')->constrained('students');
            $table->string('certificate_type'); // completion, participation, achievement
            $table->string('title'); // "Cricket Training Completion Certificate"
            $table->text('description')->nullable();
            $table->foreignId('batch_id')->nullable()->constrained('batches');
            $table->date('issue_date');
            $table->date('valid_until')->nullable();
            $table->string('template_name'); // Template used for generation
            $table->json('merge_fields'); // Data used to populate template
            $table->string('pdf_path')->nullable(); // Path to generated PDF
            $table->boolean('is_issued')->default(false);
            $table->timestamp('issued_at')->nullable();
            $table->foreignId('issued_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
