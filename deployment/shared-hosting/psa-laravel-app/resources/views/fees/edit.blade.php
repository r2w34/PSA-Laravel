@extends('layouts.dashboard')

@section('title', 'Edit Fee Payment')
@section('page-title', 'Edit Fee Payment')
@section('page-description', 'Update payment information and details')

@section('content')
<div class="space-y-6">
    <!-- Header with Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white mb-2">Edit Fee Payment</h1>
            <p class="text-gray-400">Update payment details for {{ $fee->student->name }}</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
            <a href="{{ route('fees.show', $fee) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-eye"></i>
                <span>View Payment</span>
            </a>
            <a href="{{ route('fees.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Fees</span>
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-lg p-6">
        <form action="{{ route('fees.update', $fee) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Payment Information Section -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill-wave text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Payment Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Student Selection -->
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">
                            Student <span class="text-red-400">*</span>
                        </label>
                        <select id="student_id" name="student_id" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('student_id') border-red-500 @enderror">
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id', $fee->student_id) == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->student_id }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Batch Selection -->
                    <div>
                        <label for="batch_id" class="block text-sm font-medium text-gray-300 mb-2">Batch</label>
                        <select id="batch_id" name="batch_id"
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('batch_id') border-red-500 @enderror">
                            <option value="">Select Batch</option>
                            @foreach($batches as $batch)
                                <option value="{{ $batch->id }}" {{ old('batch_id', $fee->batch_id) == $batch->id ? 'selected' : '' }}>
                                    {{ $batch->name }} ({{ $batch->sport->name ?? 'No Sport' }})
                                </option>
                            @endforeach
                        </select>
                        @error('batch_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">
                            Amount (₹) <span class="text-red-400">*</span>
                        </label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $fee->amount) }}" required min="0" step="0.01"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('amount') border-red-500 @enderror">
                        @error('amount')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fee Type -->
                    <div>
                        <label for="fee_type" class="block text-sm font-medium text-gray-300 mb-2">
                            Fee Type <span class="text-red-400">*</span>
                        </label>
                        <select id="fee_type" name="fee_type" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('fee_type') border-red-500 @enderror">
                            <option value="">Select Fee Type</option>
                            <option value="monthly" {{ old('fee_type', $fee->fee_type) == 'monthly' ? 'selected' : '' }}>Monthly Fee</option>
                            <option value="admission" {{ old('fee_type', $fee->fee_type) == 'admission' ? 'selected' : '' }}>Admission Fee</option>
                            <option value="equipment" {{ old('fee_type', $fee->fee_type) == 'equipment' ? 'selected' : '' }}>Equipment Fee</option>
                            <option value="tournament" {{ old('fee_type', $fee->fee_type) == 'tournament' ? 'selected' : '' }}>Tournament Fee</option>
                            <option value="other" {{ old('fee_type', $fee->fee_type) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('fee_type')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Date -->
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-300 mb-2">
                            Payment Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date" id="payment_date" name="payment_date" value="{{ old('payment_date', $fee->payment_date->format('Y-m-d')) }}" required
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_date') border-red-500 @enderror">
                        @error('payment_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">Due Date</label>
                        <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $fee->due_date?->format('Y-m-d')) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">
                            Payment Method <span class="text-red-400">*</span>
                        </label>
                        <select id="payment_method" name="payment_method" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_method') border-red-500 @enderror">
                            <option value="">Select Payment Method</option>
                            <option value="cash" {{ old('payment_method', $fee->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ old('payment_method', $fee->payment_method) == 'card' ? 'selected' : '' }}>Card</option>
                            <option value="upi" {{ old('payment_method', $fee->payment_method) == 'upi' ? 'selected' : '' }}>UPI</option>
                            <option value="bank_transfer" {{ old('payment_method', $fee->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cheque" {{ old('payment_method', $fee->payment_method) == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        </select>
                        @error('payment_method')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                            Payment Status <span class="text-red-400">*</span>
                        </label>
                        <select id="status" name="status" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="pending" {{ old('status', $fee->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status', $fee->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ old('status', $fee->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                        @error('status')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transaction ID -->
                    <div class="md:col-span-2">
                        <label for="transaction_id" class="block text-sm font-medium text-gray-300 mb-2">Transaction ID</label>
                        <input type="text" id="transaction_id" name="transaction_id" value="{{ old('transaction_id', $fee->transaction_id) }}"
                               placeholder="Enter transaction ID for digital payments..."
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('transaction_id') border-red-500 @enderror">
                        @error('transaction_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">Notes</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Add any additional notes about this payment..."
                                  class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes', $fee->notes) }}</textarea>
                        @error('notes')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-6 border-t border-gray-700">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-save"></i>
                    <span>Update Payment</span>
                </button>
                <a href="{{ route('fees.show', $fee) }}" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg flex items-center justify-center space-x-2 transition-colors">
                    <i class="fas fa-times"></i>
                    <span>Cancel</span>
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-populate transaction ID field based on payment method
    const paymentMethodSelect = document.getElementById('payment_method');
    const transactionIdField = document.getElementById('transaction_id');

    paymentMethodSelect.addEventListener('change', function() {
        const method = this.value;
        
        if (method === 'cash') {
            transactionIdField.value = '';
            transactionIdField.placeholder = 'Not required for cash payments';
            transactionIdField.disabled = true;
        } else {
            transactionIdField.disabled = false;
            transactionIdField.placeholder = `Enter ${method.replace('_', ' ')} transaction ID...`;
        }
    });

    // Trigger the change event on page load
    paymentMethodSelect.dispatchEvent(new Event('change'));

    // Student selection change handler
    const studentSelect = document.getElementById('student_id');
    const batchSelect = document.getElementById('batch_id');

    studentSelect.addEventListener('change', function() {
        const studentId = this.value;
        
        if (studentId) {
            // Here you could make an AJAX call to get student's current batch
            // For now, we'll just enable the batch selection
            batchSelect.disabled = false;
        } else {
            batchSelect.disabled = true;
            batchSelect.value = '';
        }
    });

    // Set due date to next month by default when payment date changes
    const paymentDateField = document.getElementById('payment_date');
    const dueDateField = document.getElementById('due_date');

    paymentDateField.addEventListener('change', function() {
        if (this.value && !dueDateField.value) {
            const paymentDate = new Date(this.value);
            const dueDate = new Date(paymentDate);
            dueDate.setMonth(dueDate.getMonth() + 1);
            
            dueDateField.value = dueDate.toISOString().split('T')[0];
        }
    });
});
</script>
@endsection