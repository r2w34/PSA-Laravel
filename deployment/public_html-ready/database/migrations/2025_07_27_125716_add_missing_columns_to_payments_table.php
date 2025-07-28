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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id')->nullable()->after('student_id');
            $table->string('description')->nullable()->after('notes');
            $table->unsignedBigInteger('created_by')->nullable()->after('description');
            
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropForeign(['created_by']);
            $table->dropColumn(['batch_id', 'description', 'created_by']);
        });
    }
};
