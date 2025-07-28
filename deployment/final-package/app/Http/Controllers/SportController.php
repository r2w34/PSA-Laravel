<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SportController extends Controller
{
    /**
     * Display a listing of sports with search and filtering
     */
    public function index(Request $request)
    {
        $query = Sport::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Get sports with batch count
        $sports = $query->withCount(['batches', 'students'])
                       ->orderBy('name')
                       ->paginate(10)
                       ->withQueryString();

        // Statistics
        $stats = [
            'total_sports' => Sport::count(),
            'active_sports' => Sport::where('is_active', true)->count(),
            'inactive_sports' => Sport::where('is_active', false)->count(),
            'total_batches' => Batch::count(),
        ];

        return view('sports.index', compact('sports', 'stats'));
    }

    /**
     * Show the form for creating a new sport
     */
    public function create()
    {
        return view('sports.create');
    }

    /**
     * Store a newly created sport in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:sports,name',
            'description' => 'nullable|string',
            'fee_structure' => 'nullable|array',
            'fee_structure.monthly' => 'nullable|numeric|min:0',
            'fee_structure.quarterly' => 'nullable|numeric|min:0',
            'fee_structure.yearly' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        
        // Handle fee structure
        if ($request->filled('fee_structure')) {
            $validated['fee_structure'] = array_filter($validated['fee_structure'], function($value) {
                return !is_null($value) && $value !== '';
            });
        }

        $sport = Sport::create($validated);

        return redirect()
            ->route('sports.show', $sport)
            ->with('success', 'Sport created successfully!');
    }

    /**
     * Display the specified sport with detailed information
     */
    public function show(Sport $sport)
    {
        $sport->load(['batches.coach', 'batches.students']);
        
        // Get sport statistics
        $stats = [
            'total_batches' => $sport->batches->count(),
            'active_batches' => $sport->batches->where('is_active', true)->count(),
            'total_students' => $sport->students->count(),
            'total_coaches' => $sport->batches->pluck('coach_id')->unique()->filter()->count(),
        ];

        // Get recent batches
        $recentBatches = $sport->batches()
                              ->with(['coach', 'students'])
                              ->where('is_active', true)
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();

        return view('sports.show', compact('sport', 'stats', 'recentBatches'));
    }

    /**
     * Show the form for editing the specified sport
     */
    public function edit(Sport $sport)
    {
        return view('sports.edit', compact('sport'));
    }

    /**
     * Update the specified sport in storage
     */
    public function update(Request $request, Sport $sport)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sports', 'name')->ignore($sport->id)
            ],
            'description' => 'nullable|string',
            'fee_structure' => 'nullable|array',
            'fee_structure.monthly' => 'nullable|numeric|min:0',
            'fee_structure.quarterly' => 'nullable|numeric|min:0',
            'fee_structure.yearly' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');
        
        // Handle fee structure
        if ($request->filled('fee_structure')) {
            $validated['fee_structure'] = array_filter($validated['fee_structure'], function($value) {
                return !is_null($value) && $value !== '';
            });
        }

        $sport->update($validated);

        return redirect()
            ->route('sports.show', $sport)
            ->with('success', 'Sport updated successfully!');
    }

    /**
     * Remove the specified sport from storage
     */
    public function destroy(Sport $sport)
    {
        // Check if sport has active batches
        $activeBatches = $sport->batches()->where('is_active', true)->count();
        
        if ($activeBatches > 0) {
            return redirect()
                ->route('sports.index')
                ->with('error', 'Cannot delete sport with active batches. Please deactivate batches first.');
        }

        // Check if sport has students
        $totalStudents = $sport->students()->count();
        
        if ($totalStudents > 0) {
            return redirect()
                ->route('sports.index')
                ->with('error', 'Cannot delete sport with enrolled students. Please transfer students first.');
        }

        $sportName = $sport->name;
        $sport->delete();

        return redirect()
            ->route('sports.index')
            ->with('success', "Sport '{$sportName}' deleted successfully!");
    }

    /**
     * Export sports data
     */
    public function export(Request $request)
    {
        $query = Sport::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $sports = $query->withCount(['batches', 'students'])->orderBy('name')->get();

        $filename = 'sports_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($sports) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Description',
                'Monthly Fee',
                'Quarterly Fee',
                'Yearly Fee',
                'Total Batches',
                'Total Students',
                'Status',
                'Created Date'
            ]);

            // CSV data
            foreach ($sports as $sport) {
                $feeStructure = $sport->fee_structure ?? [];
                fputcsv($file, [
                    $sport->id,
                    $sport->name,
                    $sport->description ?: 'N/A',
                    $feeStructure['monthly'] ?? 'N/A',
                    $feeStructure['quarterly'] ?? 'N/A',
                    $feeStructure['yearly'] ?? 'N/A',
                    $sport->batches_count,
                    $sport->students_count,
                    $sport->is_active ? 'Active' : 'Inactive',
                    $sport->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Toggle sport active status
     */
    public function toggleStatus(Sport $sport)
    {
        $sport->update(['is_active' => !$sport->is_active]);
        
        $status = $sport->is_active ? 'activated' : 'deactivated';
        
        return redirect()
            ->back()
            ->with('success', "Sport {$status} successfully!");
    }
}