<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Coach;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoachController extends BaseApiController
{
    /**
     * Display a listing of coaches.
     */
    public function index(Request $request)
    {
        $query = Coach::with(['sport', 'createdBy']);

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Filter by sport
        if ($request->has('sport_id') && !empty($request->sport_id)) {
            $query->where('sport_id', $request->sport_id);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by specialization
        if ($request->has('specialization') && !empty($request->specialization)) {
            $query->where('specialization', 'like', "%{$request->specialization}%");
        }

        // Filter by experience range
        if ($request->has('experience_min') && !empty($request->experience_min)) {
            $query->where('experience_years', '>=', $request->experience_min);
        }

        if ($request->has('experience_max') && !empty($request->experience_max)) {
            $query->where('experience_years', '<=', $request->experience_max);
        }

        // Sort by
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $coaches = $query->paginate($perPage);

        return $this->sendPaginatedResponse($coaches, 'Coaches retrieved successfully');
    }

    /**
     * Store a newly created coach.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:coaches,email',
            'phone' => 'required|string|max:20',
            'sport_id' => 'required|exists:sports,id',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'qualification' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'address' => 'required|string',
            'emergency_contact' => 'required|string|max:20',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $data = $request->all();
        $data['created_by'] = $request->user()->id;

        $coach = Coach::create($data);
        $coach->load(['sport', 'createdBy']);

        return $this->sendResponse($coach, 'Coach created successfully', 201);
    }

    /**
     * Display the specified coach.
     */
    public function show($id)
    {
        $coach = Coach::with(['sport', 'createdBy', 'batches'])->find($id);

        if (!$coach) {
            return $this->sendError('Coach not found');
        }

        return $this->sendResponse($coach, 'Coach retrieved successfully');
    }

    /**
     * Update the specified coach.
     */
    public function update(Request $request, $id)
    {
        $coach = Coach::find($id);

        if (!$coach) {
            return $this->sendError('Coach not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:coaches,email,' . $id,
            'phone' => 'sometimes|required|string|max:20',
            'sport_id' => 'sometimes|required|exists:sports,id',
            'specialization' => 'sometimes|required|string|max:255',
            'experience_years' => 'sometimes|required|integer|min:0',
            'qualification' => 'sometimes|required|string|max:255',
            'salary' => 'sometimes|required|numeric|min:0',
            'joining_date' => 'sometimes|required|date',
            'address' => 'sometimes|required|string',
            'emergency_contact' => 'sometimes|required|string|max:20',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $coach->update($request->all());
        $coach->load(['sport', 'createdBy']);

        return $this->sendResponse($coach, 'Coach updated successfully');
    }

    /**
     * Remove the specified coach.
     */
    public function destroy($id)
    {
        $coach = Coach::find($id);

        if (!$coach) {
            return $this->sendError('Coach not found');
        }

        $coach->delete();

        return $this->sendResponse([], 'Coach deleted successfully');
    }

    /**
     * Get coach statistics
     */
    public function statistics()
    {
        $stats = [
            'total_coaches' => Coach::count(),
            'active_coaches' => Coach::where('status', 'active')->count(),
            'inactive_coaches' => Coach::where('status', 'inactive')->count(),
            'average_experience' => Coach::avg('experience_years'),
            'coaches_by_sport' => Coach::with('sport')
                ->selectRaw('sport_id, count(*) as count')
                ->groupBy('sport_id')
                ->get()
                ->map(function ($item) {
                    return [
                        'sport' => $item->sport->name ?? 'Unknown',
                        'count' => $item->count
                    ];
                }),
            'recent_hires' => Coach::with(['sport'])
                ->orderBy('joining_date', 'desc')
                ->limit(5)
                ->get(),
        ];

        return $this->sendResponse($stats, 'Coach statistics retrieved successfully');
    }

    /**
     * Get sports list for dropdown
     */
    public function sports()
    {
        $sports = Sport::select('id', 'name', 'description')->where('is_active', true)->get();
        return $this->sendResponse($sports, 'Sports retrieved successfully');
    }
}
