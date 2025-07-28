@extends('layouts.dashboard')

@section('title', 'Record Fee Payment')
@section('page-title', 'Record Fee Payment')
@section('page-description', 'Record a new fee payment for a student')

@section('content')
<div class="p-4 sm:p-6 space-y-6 max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Record Fee Payment</h1>
                <p class="text-gray-400">Record a new fee payment for a student</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('fees.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Fees</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Form -->
    <div class="bg-gray-800 rounded-xl shadow-sm border border-gray-700 overflow-hidden">
        <form method="POST" action="{{ route('fees.store') }}" class="space-y-6">
            @csrf
            
            <div class="p-6 space-y-6">
                <!-- Student Search -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="student_search" class="block text-sm font-medium text-gray-300 mb-2">
                            Search Student <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="student_search" placeholder="Search by name, email, phone, or ID..." 
                                   class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                        <input type="hidden" name="student_id" id="student_id" required>
                        
                        <!-- Search Results -->
                        <div id="search_results" class="hidden absolute z-10 w-full mt-1 bg-gray-700 border border-gray-600 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            <!-- Results will be populated here -->
                        </div>
                        
                        <!-- Selected Student Display -->
                        <div id="selected_student" class="hidden mt-3 p-3 bg-gray-700 rounded-lg border border-gray-600">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-white font-medium" id="selected_student_name"></p>
                                    <p class="text-gray-400 text-sm" id="selected_student_details"></p>
                                </div>
                                <button type="button" onclick="clearSelection()" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-300 mb-2">
                            Batch <span class="text-red-400">*</span>
                        </label>
                        <select name="batch_id" id="batch_id" required 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('batch_id') border-red-500 @enderror">
                            <option value="">Select Batch</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }} ({{ $batch->sport->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">
                            Amount (₹) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="amount" id="amount" step="0.01" min="1" required
                               value="{{ old('amount') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                               placeholder="Enter amount">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">
                            Payment Method <span class="text-red-400">*</span>
                        </label>
                        <select name="payment_method" id="payment_method" required 
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_method') border-red-500 @enderror">
                            <option value="">Select Method</option>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        </select>
                        @error('payment_method')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-300 mb-2">
                            Payment Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="payment_date" id="payment_date" required
                               value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_date') border-red-500 @enderror">
                        @error('payment_date')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">
                            Due Date (Optional)
                        </label>
                        <input type="date" name="due_date" id="due_date"
                               value="{{ old('due_date') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label for="transaction_id" class="block text-sm font-medium text-gray-300 mb-2">
                            Transaction ID (Optional)
                        </label>
                        <input type="text" name="transaction_id" id="transaction_id"
                               value="{{ old('transaction_id') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('transaction_id') border-red-500 @enderror"
                               placeholder="Enter transaction ID">
                        @error('transaction_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                            Description (Optional)
                        </label>
                        <input type="text" name="description" id="description"
                               value="{{ old('description') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror"
                               placeholder="e.g., Monthly fee for July 2025">
                        @error('description')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">
                        Notes (Optional)
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-3 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror"
                              placeholder="Any additional notes about this payment...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Student Outstanding Info (will be populated via AJAX) -->
                <div id="student-info" class="hidden bg-gray-700 rounded-lg p-4 border border-gray-600">
                    <h3 class="text-lg font-medium text-white mb-3">Student Payment History</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-400">Total Paid:</span>
                            <span class="text-green-400 font-medium" id="total-paid">₹0</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Pending Amount:</span>
                            <span class="text-orange-400 font-medium" id="pending-amount">₹0</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Last Payment:</span>
                            <span class="text-white font-medium" id="last-payment">None</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-700 border-t border-gray-600 flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                <a href="{{ route('fees.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-save"></i>
                    <span>Record Payment</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSearch = document.getElementById('student_search');
    const studentIdInput = document.getElementById('student_id');
    const searchResults = document.getElementById('search_results');
    const selectedStudent = document.getElementById('selected_student');
    const batchSelect = document.getElementById('batch_id');
    const studentInfo = document.getElementById('student-info');
    
    let searchTimeout;

    // Student search functionality
    studentSearch.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            searchResults.classList.add('hidden');
            return;
        }
        
        searchTimeout = setTimeout(() => {
            searchStudents(query);
        }, 300);
    });

    function searchStudents(query) {
        fetch(`{{ route('api.students.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.students || []);
            })
            .catch(error => {
                console.error('Error searching students:', error);
                searchResults.classList.add('hidden');
            });
    }

    function displaySearchResults(students) {
        if (students.length === 0) {
            searchResults.innerHTML = '<div class="p-3 text-gray-400 text-center">No students found</div>';
            searchResults.classList.remove('hidden');
            return;
        }

        const resultsHtml = students.map(student => `
            <div class="p-3 hover:bg-gray-600 cursor-pointer border-b border-gray-600 last:border-b-0" 
                 onclick="selectStudent(${student.id}, '${student.name}', '${student.student_id}', '${student.email || ''}', '${student.phone}', '${student.sport?.name || 'No Sport'}', ${student.batch_id || 'null'})">
                <div class="font-medium text-white">${student.name}</div>
                <div class="text-sm text-gray-400">
                    ID: ${student.student_id} | ${student.email || 'No email'} | ${student.phone}
                    <br>Sport: ${student.sport?.name || 'No Sport'}
                </div>
            </div>
        `).join('');

        searchResults.innerHTML = resultsHtml;
        searchResults.classList.remove('hidden');
    }

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#student_search') && !e.target.closest('#search_results')) {
            searchResults.classList.add('hidden');
        }
    });

    window.selectStudent = function(id, name, studentId, email, phone, sport, batchId) {
        studentIdInput.value = id;
        studentSearch.value = name;
        searchResults.classList.add('hidden');
        
        // Show selected student
        document.getElementById('selected_student_name').textContent = name;
        document.getElementById('selected_student_details').textContent = `ID: ${studentId} | ${email || 'No email'} | ${phone} | Sport: ${sport}`;
        selectedStudent.classList.remove('hidden');
        
        // Auto-select batch if available
        if (batchId && batchSelect) {
            batchSelect.value = batchId;
        }
        
        // Load student payment info
        loadStudentInfo(id);
    };

    window.clearSelection = function() {
        studentIdInput.value = '';
        studentSearch.value = '';
        selectedStudent.classList.add('hidden');
        studentInfo.classList.add('hidden');
        if (batchSelect) {
            batchSelect.value = '';
        }
    };

    function loadStudentInfo(studentId) {
        fetch(`{{ route('api.student-outstanding') }}?student_id=${studentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error loading student info:', data.error);
                    return;
                }

                document.getElementById('total-paid').textContent = `₹${new Intl.NumberFormat('en-IN').format(data.total_paid)}`;
                document.getElementById('pending-amount').textContent = `₹${new Intl.NumberFormat('en-IN').format(data.pending_amount)}`;
                
                if (data.last_payment) {
                    const lastPaymentDate = new Date(data.last_payment.payment_date).toLocaleDateString('en-IN');
                    document.getElementById('last-payment').textContent = `₹${new Intl.NumberFormat('en-IN').format(data.last_payment.amount)} on ${lastPaymentDate}`;
                } else {
                    document.getElementById('last-payment').textContent = 'None';
                }

                studentInfo.classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error loading student info:', error);
            });
    }
});
</script>
@endsection