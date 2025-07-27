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
        Schema::table('inquiries', function (Blueprint $table) {
            // Add new columns
            $table->string('name')->after('id');
            $table->integer('age')->nullable()->after('email');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('age');
            $table->foreignId('batch_id')->nullable()->constrained()->onDelete('set null')->after('sport_id');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('batch_id');
            $table->enum('source', ['website', 'phone', 'walk_in', 'referral', 'social_media', 'advertisement'])->after('priority');
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('set null')->after('notes');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null')->after('created_by');
            
            // Modify existing columns
            $table->string('phone', 20)->change();
            $table->string('email')->nullable(false)->change();
        });
        
        // Update existing data
        DB::statement("UPDATE inquiries SET name = full_name");
        DB::statement("UPDATE inquiries SET source = COALESCE(lead_source, 'website')");
        
        // Drop foreign key constraints first
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign('inquiries_converted_student_id_foreign');
            $table->dropForeign('inquiries_branch_id_foreign');
        });
        
        // Drop old columns
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn([
                'inquiry_id',
                'full_name',
                'inquiry_date', 
                'lead_source',
                'tags',
                'converted_student_id',
                'converted_at',
                'branch_id'
            ]);
        });
        
        // Update status enum values
        DB::statement("ALTER TABLE inquiries MODIFY COLUMN status ENUM('new', 'in_progress', 'converted', 'closed') DEFAULT 'new'");
        
        // Map old status values to new ones
        DB::statement("UPDATE inquiries SET status = 'new' WHERE status = 'hot'");
        DB::statement("UPDATE inquiries SET status = 'in_progress' WHERE status = 'warm'");
        DB::statement("UPDATE inquiries SET status = 'closed' WHERE status = 'cold'");
        DB::statement("UPDATE inquiries SET status = 'closed' WHERE status = 'lost'");
        
        // Add indexes
        Schema::table('inquiries', function (Blueprint $table) {
            $table->index(['status', 'priority']);
            $table->index(['sport_id', 'status']);
            $table->index('follow_up_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This would be complex to reverse, so leaving empty for now
        // In production, you'd want to implement proper rollback
    }
};
