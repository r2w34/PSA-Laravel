<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            
            // Student management
            'view_students',
            'create_students',
            'edit_students',
            'delete_students',
            
            // Coach management
            'view_coaches',
            'create_coaches',
            'edit_coaches',
            'delete_coaches',
            
            // Sport management
            'view_sports',
            'create_sports',
            'edit_sports',
            'delete_sports',
            
            // Batch management
            'view_batches',
            'create_batches',
            'edit_batches',
            'delete_batches',
            
            // Payment management
            'view_payments',
            'create_payments',
            'edit_payments',
            'delete_payments',
            'view_payment_reports',
            
            // Attendance management
            'view_attendance',
            'mark_attendance',
            'edit_attendance',
            'view_attendance_reports',
            
            // Communication
            'send_messages',
            'view_communications',
            'manage_templates',
            
            // Settings
            'view_settings',
            'edit_settings',
            
            // Reports
            'view_reports',
            'export_reports',
            
            // Dashboard
            'view_admin_dashboard',
            'view_coach_dashboard',
            'view_student_dashboard',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        $coachRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'coach']);
        $studentRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'student']);

        // Assign permissions to admin (all permissions)
        $adminRole->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        // Assign permissions to coach
        $coachPermissions = [
            'view_students',
            'view_batches',
            'view_attendance',
            'mark_attendance',
            'view_attendance_reports',
            'view_payments', // Can view but not modify
            'send_messages',
            'view_communications',
            'view_coach_dashboard',
        ];
        $coachRole->givePermissionTo($coachPermissions);

        // Assign permissions to student
        $studentPermissions = [
            'view_student_dashboard',
            'view_attendance', // Own attendance only
            'view_payments', // Own payments only
        ];
        $studentRole->givePermissionTo($studentPermissions);
    }
}
