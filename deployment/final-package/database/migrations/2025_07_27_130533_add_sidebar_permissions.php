<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the missing permissions that the sidebar checks for
        $permissions = [
            'manage students',
            'manage fees', 
            'manage coaches',
            'manage sports',
            'manage payments',
            'view attendance',
            'manage inquiries',
            'generate reports',
            'manage certificates',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }

        // Also assign to coach role where appropriate
        $coachRole = Role::where('name', 'coach')->first();
        if ($coachRole) {
            $coachRole->givePermissionTo([
                'view attendance',
                'manage students', // coaches can view students
            ]);
        }

        // Also assign to student role where appropriate  
        $studentRole = Role::where('name', 'student')->first();
        if ($studentRole) {
            // Students don't need these permissions for sidebar
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = [
            'manage students',
            'manage fees',
            'manage coaches', 
            'manage sports',
            'manage payments',
            'view attendance',
            'manage inquiries',
            'generate reports',
            'manage certificates',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
};
