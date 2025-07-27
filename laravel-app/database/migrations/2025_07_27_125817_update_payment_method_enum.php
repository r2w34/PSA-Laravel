<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method ENUM('cash', 'card', 'upi', 'bank_transfer', 'cheque', 'online') NOT NULL");
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN payment_method ENUM('cash','upi','card','online') NOT NULL");
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('pending','completed','failed') NOT NULL DEFAULT 'pending'");
    }
};
