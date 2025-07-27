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
        Schema::create('fee_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique(); // RCP001, RCP002, etc.
            $table->foreignId('payment_id')->constrained('payments');
            $table->foreignId('student_id')->constrained('students');
            $table->decimal('amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('payment_mode'); // cash, upi, card, online
            $table->string('paid_by')->nullable(); // Name of person who paid
            $table->timestamp('paid_on');
            $table->text('remarks')->nullable();
            $table->string('pdf_path')->nullable(); // Path to generated PDF
            $table->boolean('is_printed')->default(false);
            $table->timestamp('printed_at')->nullable();
            $table->foreignId('generated_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_receipts');
    }
};
