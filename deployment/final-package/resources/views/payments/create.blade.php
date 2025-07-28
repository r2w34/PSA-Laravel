@extends('layouts.dashboard')

@section('title', 'Add New Payment')
@section('page-title', 'Add New Payment')
@section('page-description', 'Create a new payment record')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
        <form action="{{ route('payments.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Selection -->
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Student <span class="text-red-400">*</span>
                    </label>
                    <select id="student_id" 
                            name="student_id" 
                            required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('student_id') border-red-500 @enderror">
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }} - {{ $student->phone }}
                        </option>
                        @endforeach
                    </select>
                    @error('student_id')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Batch Selection -->
                <div>
                    <label for="batch_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Batch (Optional)
                    </label>
                    <select id="batch_id" 
                            name="batch_id"
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('batch_id') border-red-500 @enderror">
                        <option value="">Select Batch</option>
                        @foreach($batches as $batch)
                        <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>
                            {{ $batch->name }} - {{ $batch->sport->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('batch_id')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">
                        Amount <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-400">₹</span>
                        <input type="number" 
                               id="amount" 
                               name="amount" 
                               value="{{ old('amount') }}"
                               step="0.01"
                               min="0"
                               required
                               placeholder="0.00"
                               class="w-full pl-8 pr-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('amount') border-red-500 @enderror">
                    </div>
                    @error('amount')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Type -->
                <div>
                    <label for="payment_type" class="block text-sm font-medium text-gray-300 mb-2">
                        Payment Type <span class="text-red-400">*</span>
                    </label>
                    <select id="payment_type" 
                            name="payment_type" 
                            required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_type') border-red-500 @enderror">
                        <option value="">Select Payment Type</option>
                        <option value="monthly" {{ old('payment_type') == 'monthly' ? 'selected' : '' }}>Monthly Fee</option>
                        <option value="registration" {{ old('payment_type') == 'registration' ? 'selected' : '' }}>Registration Fee</option>
                        <option value="tournament" {{ old('payment_type') == 'tournament' ? 'selected' : '' }}>Tournament Fee</option>
                    </select>
                    @error('payment_type')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-300 mb-2">
                        Payment Method <span class="text-red-400">*</span>
                    </label>
                    <select id="payment_method" 
                            name="payment_method" 
                            required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_method') border-red-500 @enderror">
                        <option value="">Select Payment Method</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                        <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                    @error('payment_method')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-300 mb-2">
                        Status <span class="text-red-400">*</span>
                    </label>
                    <select id="status" 
                            name="status" 
                            required
                            class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="">Select Status</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : 'selected' }}>Completed</option>
                        <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                    @error('status')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transaction ID -->
                <div>
                    <label for="transaction_id" class="block text-sm font-medium text-gray-300 mb-2">
                        Transaction ID (Optional)
                    </label>
                    <input type="text" 
                           id="transaction_id" 
                           name="transaction_id" 
                           value="{{ old('transaction_id') }}"
                           placeholder="Enter transaction ID"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('transaction_id') border-red-500 @enderror">
                    @error('transaction_id')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Date -->
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Payment Date <span class="text-red-400">*</span>
                    </label>
                    <input type="datetime-local" 
                           id="payment_date" 
                           name="payment_date" 
                           value="{{ old('payment_date', now()->format('Y-m-d\TH:i')) }}"
                           required
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('payment_date') border-red-500 @enderror">
                    @error('payment_date')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Due Date -->
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-300 mb-2">
                        Due Date (Optional)
                    </label>
                    <input type="datetime-local" 
                           id="due_date" 
                           name="due_date" 
                           value="{{ old('due_date') }}"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('due_date') border-red-500 @enderror">
                    @error('due_date')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Month/Year -->
                <div>
                    <label for="month_year" class="block text-sm font-medium text-gray-300 mb-2">
                        Month/Year (Optional)
                    </label>
                    <input type="text" 
                           id="month_year" 
                           name="month_year" 
                           value="{{ old('month_year') }}"
                           placeholder="e.g., July 2025"
                           class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('month_year') border-red-500 @enderror">
                    @error('month_year')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                    Description (Optional)
                </label>
                <input type="text" 
                       id="description" 
                       name="description" 
                       value="{{ old('description') }}"
                       placeholder="Brief description of the payment"
                       class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('description') border-red-500 @enderror">
                @error('description')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-300 mb-2">
                    Notes (Optional)
                </label>
                <textarea id="notes" 
                          name="notes" 
                          rows="3"
                          placeholder="Additional notes about the payment"
                          class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-700">
                <a href="{{ route('payments.index') }}" 
                   class="inline-flex items-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Payments
                </a>
                
                <div class="flex space-x-3">
                    <button type="reset" 
                            class="inline-flex items-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-undo mr-2"></i>
                        Reset
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>
                        Create Payment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-populate month/year based on payment type and date
document.getElementById('payment_type').addEventListener('change', function() {
    const paymentType = this.value;
    const paymentDate = document.getElementById('payment_date').value;
    const monthYearField = document.getElementById('month_year');
    
    if (paymentType === 'monthly' && paymentDate) {
        const date = new Date(paymentDate);
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        const monthYear = monthNames[date.getMonth()] + ' ' + date.getFullYear();
        monthYearField.value = monthYear;
    }
});

document.getElementById('payment_date').addEventListener('change', function() {
    const paymentType = document.getElementById('payment_type').value;
    const paymentDate = this.value;
    const monthYearField = document.getElementById('month_year');
    
    if (paymentType === 'monthly' && paymentDate) {
        const date = new Date(paymentDate);
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];
        const monthYear = monthNames[date.getMonth()] + ' ' + date.getFullYear();
        monthYearField.value = monthYear;
    }
});
</script>
@endsection