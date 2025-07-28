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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, boolean, integer, json
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('system_settings')->insert([
            [
                'key' => 'currency',
                'value' => 'INR',
                'type' => 'string',
                'description' => 'Default currency for the application',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'date_format',
                'value' => 'Y-m-d',
                'type' => 'string',
                'description' => 'Default date format',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'time_format',
                'value' => 'H:i',
                'type' => 'string',
                'description' => 'Default time format',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'whatsapp_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable WhatsApp notifications',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'fee_reminder_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable fee reminder notifications',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'fee_reminder_days',
                'value' => '3',
                'type' => 'integer',
                'description' => 'Days before due date to send fee reminders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'attendance_notification_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable attendance notifications',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'session_reminder_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable session reminder notifications',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'session_reminder_hours',
                'value' => '2',
                'type' => 'integer',
                'description' => 'Hours before session to send reminders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
