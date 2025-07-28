<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Role-based dashboard routing
        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'coach':
                return $this->coachDashboard();
            case 'student':
                return $this->studentDashboard();
            default:
                return $this->adminDashboard();
        }
    }
    
    private function adminDashboard()
    {
        // Get admin dashboard statistics
        $stats = [
            'total_students' => \App\Models\Student::count(),
            'total_coaches' => \App\Models\User::where('role', 'coach')->count(),
            'total_sports' => \App\Models\Sport::count(),
            'total_batches' => \App\Models\Batch::count(),
            'active_students' => \App\Models\Student::where('is_active', true)->count(),
            'pending_payments' => \App\Models\Payment::where('status', 'pending')->count(),
            'total_revenue' => \App\Models\Payment::where('status', 'completed')->sum('amount'),
            'recent_inquiries' => \App\Models\Inquiry::where('status', 'new')->count(),
        ];
        
        // Get recent activities
        $recentActivities = \App\Models\Activity::with('user')
            ->latest()
            ->take(10)
            ->get();
            
        // Get recent payments
        $recentPayments = \App\Models\Payment::with(['student', 'batch'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.admin', compact('stats', 'recentActivities', 'recentPayments'));
    }
    
    private function coachDashboard()
    {
        $user = Auth::user();
        
        // Get coach's batches and students
        $batches = \App\Models\Batch::where('coach_id', $user->id)->get();
        $students = \App\Models\Student::whereIn('batch_id', $batches->pluck('id'))->get();
        
        $stats = [
            'my_batches' => $batches->count(),
            'my_students' => $students->count(),
            'todays_sessions' => $batches->where('schedule_day', now()->format('l'))->count(),
            'attendance_today' => \App\Models\Attendance::whereIn('batch_id', $batches->pluck('id'))
                ->whereDate('date', today())
                ->count(),
        ];
        
        return view('dashboard.coach', compact('stats', 'batches', 'students'));
    }
    
    private function studentDashboard()
    {
        $user = Auth::user();
        $student = \App\Models\Student::where('user_id', $user->id)->first();
        
        if (!$student) {
            return redirect()->route('profile')->with('error', 'Student profile not found. Please complete your profile.');
        }
        
        $stats = [
            'my_batch' => $student->batch->name ?? 'Not assigned',
            'sport' => $student->batch->sport->name ?? 'Not assigned',
            'coach' => $student->batch->coach->name ?? 'Not assigned',
            'attendance_rate' => $this->calculateAttendanceRate($student),
            'pending_fees' => \App\Models\Payment::where('student_id', $student->id)
                ->where('status', 'pending')
                ->sum('amount'),
        ];
        
        // Get recent attendance
        $recentAttendance = \App\Models\Attendance::where('student_id', $student->id)
            ->with('batch')
            ->latest()
            ->take(10)
            ->get();
            
        // Get payment history
        $payments = \App\Models\Payment::where('student_id', $student->id)
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.student', compact('stats', 'student', 'recentAttendance', 'payments'));
    }
    
    private function calculateAttendanceRate($student)
    {
        $totalSessions = \App\Models\Attendance::where('student_id', $student->id)->count();
        $presentSessions = \App\Models\Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();
            
        return $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 1) : 0;
    }
}
