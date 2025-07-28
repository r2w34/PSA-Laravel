@extends('layouts.dashboard')

@section('title', 'Inquiry Details')
@section('page-title', 'Inquiry Details')
@section('page-description', 'View detailed information about this inquiry')

@section('content')
<div class="space-y-6">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Inquiry Details</h1>
                    <p class="mt-2 text-gray-400">View inquiry information and manage follow-ups</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('inquiries.edit', $inquiry) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('inquiries.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Personal Information -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Personal Information</h3>
                        
                        <div class="flex items-center mt-4">
                            <div class="flex-shrink-0 h-16 w-16">
                                <div class="h-16 w-16 rounded-full bg-purple-600 flex items-center justify-center">
                                    <span class="text-xl font-medium text-white">
                                        {{ strtoupper(substr($inquiry->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-6">
                                <h2 class="text-xl font-semibold text-white">{{ $inquiry->name }}</h2>
                                <p class="text-gray-400">{{ $inquiry->email }}</p>
                                <p class="text-gray-400">{{ $inquiry->phone }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Age</label>
                                <p class="text-white">{{ $inquiry->age ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Gender</label>
                                <p class="text-white">{{ $inquiry->gender ? ucfirst($inquiry->gender) : 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Inquiry Date</label>
                                <p class="text-white">{{ $inquiry->created_at->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-400">{{ $inquiry->created_at->format('l, g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sport & Batch Information -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Sport & Batch Interest</h3>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Interested Sport</label>
                                <p class="text-white text-lg">{{ $inquiry->sport->name ?? 'N/A' }}</p>
                                @if($inquiry->sport)
                                    <p class="text-sm text-gray-400">{{ $inquiry->sport->description ?? '' }}</p>
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Preferred Batch</label>
                                @if($inquiry->batch)
                                    <p class="text-white">{{ $inquiry->batch->name }}</p>
                                    <p class="text-sm text-gray-400">
                                        {{ $inquiry->batch->schedule ?? 'Schedule not set' }}
                                    </p>
                                    <p class="text-sm text-gray-400">
                                        Capacity: {{ $inquiry->batch->current_students ?? 0 }}/{{ $inquiry->batch->max_students ?? 'N/A' }}
                                    </p>
                                @else
                                    <p class="text-gray-400">No specific batch preference</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($inquiry->notes)
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Notes</h3>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="prose prose-invert max-w-none">
                            <p class="text-gray-300 whitespace-pre-line">{{ $inquiry->notes }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Conversion Section -->
                @if($inquiry->status !== 'converted' && $inquiry->status !== 'closed')
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Convert to Student</h3>
                        <p class="text-sm text-gray-400 mt-1">Convert this inquiry into a registered student</p>
                    </div>
                    
                    <div class="px-6 py-4">
                        <button onclick="showConversionModal()" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-user-plus mr-2"></i>
                            Convert to Student
                        </button>
                    </div>
                </div>
                @elseif($inquiry->status === 'converted' && $inquiry->student)
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Converted Student</h3>
                        <p class="text-sm text-gray-400 mt-1">This inquiry has been converted to a student</p>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-white font-medium">{{ $inquiry->student->name }}</p>
                                <p class="text-sm text-gray-400">Student ID: {{ $inquiry->student->student_id }}</p>
                            </div>
                            <a href="{{ route('students.show', $inquiry->student) }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                View Student
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                
                <!-- Status & Priority -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Status & Priority</h3>
                    </div>
                    
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Current Status</label>
                            @php
                                $statusColors = [
                                    'new' => 'bg-yellow-100 text-yellow-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'converted' => 'bg-green-100 text-green-800',
                                    'closed' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$inquiry->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $inquiry->status)) }}
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Priority Level</label>
                            @php
                                $priorityColors = [
                                    'low' => 'bg-gray-100 text-gray-800',
                                    'medium' => 'bg-orange-100 text-orange-800',
                                    'high' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $priorityColors[$inquiry->priority] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($inquiry->priority) }} Priority
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Inquiry Source</label>
                            <p class="text-white">{{ ucfirst(str_replace('_', ' ', $inquiry->source)) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Follow-up Information -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Follow-up</h3>
                    </div>
                    
                    <div class="px-6 py-4">
                        @if($inquiry->follow_up_date)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-400 mb-1">Follow-up Date</label>
                                <p class="text-white">{{ $inquiry->follow_up_date->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-400">{{ $inquiry->follow_up_date->format('l') }}</p>
                                
                                @if($inquiry->follow_up_date->isPast())
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full mt-2">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Overdue
                                    </span>
                                @elseif($inquiry->follow_up_date->isToday())
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full mt-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        Due Today
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full mt-2">
                                        <i class="fas fa-calendar-check mr-1"></i>
                                        Upcoming
                                    </span>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-400 mb-4">No follow-up date set</p>
                        @endif
                        
                        <button onclick="updateStatus({{ $inquiry->id }})" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Update Status
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Quick Actions</h3>
                    </div>
                    
                    <div class="px-6 py-4 space-y-3">
                        <a href="{{ route('inquiries.edit', $inquiry) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Inquiry
                        </a>
                        
                        @if($inquiry->sport)
                            <a href="{{ route('sports.show', $inquiry->sport) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-futbol mr-2"></i>
                                View Sport
                            </a>
                        @endif
                        
                        @if($inquiry->batch)
                            <a href="{{ route('batches.show', $inquiry->batch) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-users mr-2"></i>
                                View Batch
                            </a>
                        @endif
                        
                        <div class="pt-3 border-t border-gray-700">
                            <form action="{{ route('inquiries.destroy', $inquiry) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this inquiry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete Inquiry
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Record Information -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-700">
                        <h3 class="text-lg font-semibold text-white">Record Information</h3>
                    </div>
                    
                    <div class="px-6 py-4 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Created:</span>
                            <span class="text-white">{{ $inquiry->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Updated:</span>
                            <span class="text-white">{{ $inquiry->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Created By:</span>
                            <span class="text-white">{{ $inquiry->createdBy->name ?? 'System' }}</span>
                        </div>
                        @if($inquiry->assignedTo)
                            <div class="flex justify-between">
                                <span class="text-gray-400">Assigned To:</span>
                                <span class="text-white">{{ $inquiry->assignedTo->name }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-400">Inquiry ID:</span>
                            <span class="text-white">#{{ $inquiry->id }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-white mb-4">Update Inquiry Status</h3>
            <form id="statusForm" method="POST" action="{{ route('inquiries.update-status', $inquiry) }}">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select id="modalStatus" name="status" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>New</option>
                        <option value="in_progress" {{ $inquiry->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="converted" {{ $inquiry->status == 'converted' ? 'selected' : '' }}>Converted</option>
                        <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Notes (Optional)</label>
                    <textarea id="modalNotes" name="notes" rows="3" class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Add status update notes..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeStatusModal()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        Update Status
                    </button>
                </div>
            </form>
    </div>
</div>

<script>
function updateStatus(inquiryId) {
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    document.getElementById('modalNotes').value = '';
}

function showConversionModal() {
    // This would open a modal for converting to student
    // For now, redirect to edit page with a flag
    window.location.href = "{{ route('inquiries.edit', $inquiry) }}?convert=1";
}
</script>
@endsection