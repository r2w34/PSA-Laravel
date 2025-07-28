<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Sport;
use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function dashboard()
    {
        // Get date range from request or default to current month
        $startDate = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Revenue Analytics
        $revenueData = $this->getRevenueAnalytics($startDate, $endDate);
        
        // Student Analytics
        $studentData = $this->getStudentAnalytics($startDate, $endDate);
        
        // Attendance Analytics
        $attendanceData = $this->getAttendanceAnalytics($startDate, $endDate);
        
        // Fee Collection Analytics
        $feeData = $this->getFeeAnalytics($startDate, $endDate);
        
        // Sports Performance
        $sportsData = $this->getSportsAnalytics($startDate, $endDate);

        return view('reports.dashboard', compact(
            'revenueData', 
            'studentData', 
            'attendanceData', 
            'feeData', 
            'sportsData',
            'startDate',
            'endDate'
        ));
    }

    public function revenue()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $data = $this->getRevenueAnalytics($startDate, $endDate);
        
        return view('reports.revenue', compact('data', 'startDate', 'endDate'));
    }

    public function students()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $data = $this->getStudentAnalytics($startDate, $endDate);
        
        return view('reports.students', compact('data', 'startDate', 'endDate'));
    }

    public function attendance()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $data = $this->getAttendanceAnalytics($startDate, $endDate);
        
        return view('reports.attendance', compact('data', 'startDate', 'endDate'));
    }

    public function fees()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = request('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $data = $this->getFeeAnalytics($startDate, $endDate);
        
        return view('reports.fees', compact('data', 'startDate', 'endDate'));
    }

    private function getRevenueAnalytics($startDate, $endDate)
    {
        // Total revenue
        $totalRevenue = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount') ?? 0;

        // Revenue by month
        $monthlyRevenue = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->selectRaw('MONTH(payment_date) as month, YEAR(payment_date) as year, SUM(amount) as total')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Revenue by sport - simplified to avoid complex joins
        $revenueBySport = Payment::join('students', 'payments.student_id', '=', 'students.id')
            ->join('sports', 'students.sport_id', '=', 'sports.id')
            ->whereBetween('payments.payment_date', [$startDate, $endDate])
            ->where('payments.status', 'completed')
            ->selectRaw('sports.name as sport_name, SUM(payments.amount) as total')
            ->groupBy('sports.id', 'sports.name')
            ->get();

        // Average payment amount
        $avgPayment = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->avg('amount') ?? 0;

        return [
            'total_revenue' => $totalRevenue,
            'monthly_revenue' => $monthlyRevenue,
            'revenue_by_sport' => $revenueBySport,
            'avg_payment' => $avgPayment,
        ];
    }

    private function getStudentAnalytics($startDate, $endDate)
    {
        // Total students
        $totalStudents = Student::where('is_active', true)->count();

        // New students in period
        $newStudents = Student::whereBetween('created_at', [$startDate, $endDate])->count();

        // Students by sport
        $studentsBySport = Student::join('sports', 'students.sport_id', '=', 'sports.id')
            ->where('students.is_active', true)
            ->selectRaw('sports.name as sport_name, COUNT(*) as count')
            ->groupBy('sports.id', 'sports.name')
            ->get();

        // Students by batch
        $studentsByBatch = Student::join('batches', 'students.batch_id', '=', 'batches.id')
            ->where('students.is_active', true)
            ->selectRaw('batches.name as batch_name, COUNT(*) as count')
            ->groupBy('batches.id', 'batches.name')
            ->get();

        // Age distribution
        $ageDistribution = Student::where('is_active', true)
            ->selectRaw('
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) < 10 THEN "Under 10"
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 10 AND 15 THEN "10-15"
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 16 AND 20 THEN "16-20"
                    ELSE "Over 20"
                END as age_group,
                COUNT(*) as count
            ')
            ->groupBy('age_group')
            ->get();

        return [
            'total_students' => $totalStudents,
            'new_students' => $newStudents,
            'students_by_sport' => $studentsBySport,
            'students_by_batch' => $studentsByBatch,
            'age_distribution' => $ageDistribution,
        ];
    }

    private function getAttendanceAnalytics($startDate, $endDate)
    {
        // Overall attendance rate
        $totalSessions = Attendance::whereBetween('date', [$startDate, $endDate])->count();
        $presentSessions = Attendance::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'present')
            ->count();
        
        $attendanceRate = $totalSessions > 0 ? ($presentSessions / $totalSessions) * 100 : 0;

        // Attendance by sport
        $attendanceBySport = Attendance::join('students', 'attendance.student_id', '=', 'students.id')
            ->join('sports', 'students.sport_id', '=', 'sports.id')
            ->whereBetween('attendance.date', [$startDate, $endDate])
            ->selectRaw('
                sports.name as sport_name,
                COUNT(*) as total_sessions,
                SUM(CASE WHEN attendance.status = "present" THEN 1 ELSE 0 END) as present_sessions,
                ROUND((SUM(CASE WHEN attendance.status = "present" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_rate
            ')
            ->groupBy('sports.id', 'sports.name')
            ->get();

        // Daily attendance trend
        $dailyAttendance = Attendance::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('
                date,
                COUNT(*) as total_sessions,
                SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_sessions,
                ROUND((SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_rate
            ')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'overall_rate' => $attendanceRate,
            'attendance_by_sport' => $attendanceBySport,
            'daily_attendance' => $dailyAttendance,
            'total_sessions' => $totalSessions,
            'present_sessions' => $presentSessions,
        ];
    }

    private function getFeeAnalytics($startDate, $endDate)
    {
        // Use Payment model directly since Fee maps to payments table
        // Total fees generated
        $totalFees = Payment::whereBetween('payment_date', [$startDate, $endDate])->sum('amount') ?? 0;

        // Collected fees
        $collectedFees = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('amount') ?? 0;

        // Pending fees
        $pendingFees = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'pending')
            ->sum('amount') ?? 0;

        // Collection rate
        $collectionRate = $totalFees > 0 ? ($collectedFees / $totalFees) * 100 : 0;

        // Overdue fees (payments that are still pending)
        $overdueFees = Payment::where('payment_date', '<', Carbon::now())
            ->where('status', 'pending')
            ->sum('amount') ?? 0;

        // Fee collection by sport
        $feesBySport = Payment::join('students', 'payments.student_id', '=', 'students.id')
            ->join('sports', 'students.sport_id', '=', 'sports.id')
            ->whereBetween('payments.payment_date', [$startDate, $endDate])
            ->selectRaw('
                sports.name as sport_name,
                SUM(payments.amount) as total_fees,
                SUM(CASE WHEN payments.status = "completed" THEN payments.amount ELSE 0 END) as collected_fees,
                ROUND((SUM(CASE WHEN payments.status = "completed" THEN payments.amount ELSE 0 END) / SUM(payments.amount)) * 100, 2) as collection_rate
            ')
            ->groupBy('sports.id', 'sports.name')
            ->get();

        return [
            'total_fees' => $totalFees,
            'collected_fees' => $collectedFees,
            'pending_fees' => $pendingFees,
            'collection_rate' => $collectionRate,
            'overdue_fees' => $overdueFees,
            'fees_by_sport' => $feesBySport,
        ];
    }

    private function getSportsAnalytics($startDate, $endDate)
    {
        // Sports popularity (by student count)
        $sportsPopularity = Sport::withCount(['students' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('students_count', 'desc')
            ->get();

        // Sports revenue - simplified join
        $sportsRevenue = Payment::join('students', 'payments.student_id', '=', 'students.id')
            ->join('sports', 'students.sport_id', '=', 'sports.id')
            ->whereBetween('payments.payment_date', [$startDate, $endDate])
            ->where('payments.status', 'completed')
            ->selectRaw('sports.name as sport_name, SUM(payments.amount) as revenue')
            ->groupBy('sports.id', 'sports.name')
            ->orderBy('revenue', 'desc')
            ->get();

        return [
            'sports_popularity' => $sportsPopularity,
            'sports_revenue' => $sportsRevenue,
        ];
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'revenue');
        $format = $request->get('format', 'pdf');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        switch ($type) {
            case 'revenue':
                $data = $this->getRevenueAnalytics($startDate, $endDate);
                break;
            case 'students':
                $data = $this->getStudentAnalytics($startDate, $endDate);
                break;
            case 'attendance':
                $data = $this->getAttendanceAnalytics($startDate, $endDate);
                break;
            case 'fees':
                $data = $this->getFeeAnalytics($startDate, $endDate);
                break;
            default:
                $data = $this->getRevenueAnalytics($startDate, $endDate);
        }

        if ($format === 'pdf') {
            return $this->exportToPdf($type, $data, $startDate, $endDate);
        } else {
            return $this->exportToExcel($type, $data, $startDate, $endDate);
        }
    }

    private function exportToPdf($type, $data, $startDate, $endDate)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('reports.pdf.' . $type, compact('data', 'startDate', 'endDate'));
        
        return $pdf->download($type . '_report_' . $startDate . '_to_' . $endDate . '.pdf');
    }

    private function exportToExcel($type, $data, $startDate, $endDate)
    {
        // Implementation for Excel export would go here
        // For now, return JSON
        return response()->json($data);
    }
}