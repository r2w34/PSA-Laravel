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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_type', ['monthly', 'registration', 'tournament']);
            $table->enum('payment_method', ['cash', 'upi', 'card', 'online']);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('receipt_number')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->string('month_year')->nullable(); // "2025-01" for monthly payments
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
