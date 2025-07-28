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
        Schema::create('report_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // fee_summary, attendance, performance, inquiry_funnel
            $table->text('description')->nullable();
            $table->json('fields'); // Fields to include in report
            $table->json('filters')->nullable(); // Default filters
            $table->json('formatting')->nullable(); // Styling and layout options
            $table->string('export_format')->default('pdf'); // pdf, excel, csv
            $table->boolean('is_scheduled')->default(false);
            $table->string('schedule_frequency')->nullable(); // daily, weekly, monthly
            $table->json('schedule_recipients')->nullable(); // Email addresses
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_templates');
    }
};
