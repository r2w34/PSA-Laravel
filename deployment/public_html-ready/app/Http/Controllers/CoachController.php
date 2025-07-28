<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Batch;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CoachController extends Controller
{
    /**
     * Display a listing of coaches with search and filtering
     */
    public function index(Request $request)
    {
        $query = Coach::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
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

        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', 'like', "%{$request->specialization}%");
        }

        // Filter by experience range
        if ($request->filled('experience_min')) {
            $query->where('experience', '>=', $request->experience_min);
        }
        if ($request->filled('experience_max')) {
            $query->where('experience', '<=', $request->experience_max);
        }

        // Get coaches with batch count
        $coaches = $query->withCount('batches')
                        ->orderBy('name')
                        ->paginate(10)
                        ->withQueryString();

        // Get filter options
        $specializations = Coach::distinct()
                               ->pluck('specialization')
                               ->filter()
                               ->sort()
                               ->values();

        // Statistics
        $stats = [
            'total_coaches' => Coach::count(),
            'active_coaches' => Coach::where('is_active', true)->count(),
            'inactive_coaches' => Coach::where('is_active', false)->count(),
            'avg_experience' => round(Coach::avg('experience'), 1),
        ];

        return view('coaches.index', compact('coaches', 'specializations', 'stats'));
    }

    /**
     * Show the form for creating a new coach
     */
    public function create()
    {
        $sports = Sport::orderBy('name')->get();
        return view('coaches.create', compact('sports'));
    }

    /**
     * Store a newly created coach in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:coaches,email',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0|max:50',
            'qualifications' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');

        $coach = Coach::create($validated);

        return redirect()
            ->route('coaches.show', $coach)
            ->with('success', 'Coach created successfully!');
    }

    /**
     * Display the specified coach with detailed information
     */
    public function show(Coach $coach)
    {
        $coach->load(['batches.sport', 'batches.students']);
        
        // Get coach statistics
        $stats = [
            'total_batches' => $coach->batches->count(),
            'active_batches' => $coach->batches->where('is_active', true)->count(),
            'total_students' => $coach->batches->sum(function ($batch) {
                return $batch->students->count();
            }),
            'sports_taught' => $coach->batches->pluck('sport.name')->unique()->filter()->count(),
        ];

        // Get recent batches
        $recentBatches = $coach->batches()
                              ->with(['sport', 'students'])
                              ->where('is_active', true)
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();

        return view('coaches.show', compact('coach', 'stats', 'recentBatches'));
    }

    /**
     * Show the form for editing the specified coach
     */
    public function edit(Coach $coach)
    {
        $sports = Sport::orderBy('name')->get();
        return view('coaches.edit', compact('coach', 'sports'));
    }

    /**
     * Update the specified coach in storage
     */
    public function update(Request $request, Coach $coach)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                Rule::unique('coaches', 'email')->ignore($coach->id)
            ],
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0|max:50',
            'qualifications' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Set default values
        $validated['is_active'] = $request->has('is_active');

        $coach->update($validated);

        return redirect()
            ->route('coaches.show', $coach)
            ->with('success', 'Coach updated successfully!');
    }

    /**
     * Remove the specified coach from storage
     */
    public function destroy(Coach $coach)
    {
        // Check if coach has active batches
        $activeBatches = $coach->batches()->where('is_active', true)->count();
        
        if ($activeBatches > 0) {
            return redirect()
                ->route('coaches.index')
                ->with('error', 'Cannot delete coach with active batches. Please reassign or deactivate batches first.');
        }

        $coachName = $coach->name;
        $coach->delete();

        return redirect()
            ->route('coaches.index')
            ->with('success', "Coach '{$coachName}' deleted successfully!");
    }

    /**
     * Export coaches data
     */
    public function export(Request $request)
    {
        $query = Coach::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $coaches = $query->withCount('batches')->orderBy('name')->get();

        $filename = 'coaches_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($coaches) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Email',
                'Phone',
                'Specialization',
                'Experience (Years)',
                'Qualifications',
                'Total Batches',
                'Status',
                'Created Date'
            ]);

            // CSV data
            foreach ($coaches as $coach) {
                fputcsv($file, [
                    $coach->id,
                    $coach->name,
                    $coach->email ?: 'N/A',
                    $coach->phone,
                    $coach->specialization,
                    $coach->experience,
                    $coach->qualifications ?: 'N/A',
                    $coach->batches_count,
                    $coach->is_active ? 'Active' : 'Inactive',
                    $coach->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Toggle coach active status
     */
    public function toggleStatus(Coach $coach)
    {
        $coach->update(['is_active' => !$coach->is_active]);
        
        $status = $coach->is_active ? 'activated' : 'deactivated';
        
        return redirect()
            ->back()
            ->with('success', "Coach {$status} successfully!");
    }
}
