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
        // Update existing data if not already done
        DB::statement("UPDATE inquiries SET name = full_name WHERE name = ''");
        DB::statement("UPDATE inquiries SET source = COALESCE(lead_source, 'website') WHERE source IS NULL");
        
        // Drop foreign key constraints for columns we want to remove
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
        //
    }
};
