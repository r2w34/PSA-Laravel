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
        Schema::table('batches', function (Blueprint $table) {
            // Add missing columns
            $table->text('description')->nullable()->after('name');
            $table->time('start_time')->nullable()->after('schedule');
            $table->time('end_time')->nullable()->after('start_time');
            
            // Rename current_capacity to current_students
            $table->renameColumn('current_capacity', 'current_students');
            
            // Make coach_id nullable
            $table->foreignId('coach_id')->nullable()->change();
            
            // Change schedule from JSON to string
            $table->string('schedule')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn(['description', 'start_time', 'end_time']);
            $table->renameColumn('current_students', 'current_capacity');
            $table->foreignId('coach_id')->nullable(false)->change();
            $table->json('schedule')->change();
        });
    }
};
