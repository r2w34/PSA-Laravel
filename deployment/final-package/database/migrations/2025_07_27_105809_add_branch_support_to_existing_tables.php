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
        // Add branch_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches')->after('id');
        });

        // Add branch_id to coaches table
        Schema::table('coaches', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches')->after('id');
        });

        // Add branch_id to sports table
        Schema::table('sports', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches')->after('id');
        });

        // Add branch_id to batches table
        Schema::table('batches', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches')->after('id');
        });

        // Add branch_id to students table
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches')->after('id');
        });

        // Add branch_id to inquiries table
        Schema::table('inquiries', function (Blueprint $table) {
            $table->foreignId('branch_id')->nullable()->constrained('branches')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('sports', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('batches', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
