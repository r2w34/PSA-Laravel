@extends('layouts.dashboard')

@section('title', 'Payment Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">Payment Settings</h1>
            <p class="text-gray-400 mt-1">Configure payment gateways and billing options</p>
        </div>
        <a href="{{ route('settings.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Settings
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-400 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Payment Configuration -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <form action="{{ route('settings.payment.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Razorpay Configuration -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-credit-card text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Razorpay Configuration</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Razorpay Key ID -->
                    <div>
                        <label for="razorpay_key_id" class="block text-sm font-medium text-gray-300 mb-2">
                            Razorpay Key ID
                        </label>
                        <input type="text" id="razorpay_key_id" name="razorpay_key_id" 
                               value="{{ old('razorpay_key_id', env('RAZORPAY_KEY_ID')) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('razorpay_key_id') border-red-500 @enderror"
                               placeholder="rzp_test_xxxxxxxxxx">
                        @error('razorpay_key_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Razorpay Key Secret -->
                    <div>
                        <label for="razorpay_key_secret" class="block text-sm font-medium text-gray-300 mb-2">
                            Razorpay Key Secret
                        </label>
                        <input type="password" id="razorpay_key_secret" name="razorpay_key_secret" 
                               value="{{ old('razorpay_key_secret', env('RAZORPAY_KEY_SECRET')) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('razorpay_key_secret') border-red-500 @enderror"
                               placeholder="Your Razorpay Key Secret">
                        @error('razorpay_key_secret')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Razorpay Webhook Secret -->
                    <div class="md:col-span-2">
                        <label for="razorpay_webhook_secret" class="block text-sm font-medium text-gray-300 mb-2">
                            Razorpay Webhook Secret
                        </label>
                        <input type="password" id="razorpay_webhook_secret" name="razorpay_webhook_secret" 
                               value="{{ old('razorpay_webhook_secret', env('RAZORPAY_WEBHOOK_SECRET')) }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('razorpay_webhook_secret') border-red-500 @enderror"
                               placeholder="Your Razorpay Webhook Secret">
                        @error('razorpay_webhook_secret')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-400 text-sm mt-1">Used to verify webhook authenticity</p>
                    </div>
                </div>
            </div>

            <!-- General Payment Settings -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">General Settings</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Payment Enabled -->
                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="payment_enabled" value="1" 
                                   {{ old('payment_enabled', $settings['payment_enabled'] ?? false) ? 'checked' : '' }}
                                   class="w-5 h-5 text-purple-600 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                            <span class="text-gray-300">Enable Online Payments</span>
                        </label>
                        <p class="text-gray-400 text-sm mt-1">Allow students to pay fees online</p>
                    </div>

                    <!-- Currency -->
                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-300 mb-2">
                            Currency <span class="text-red-400">*</span>
                        </label>
                        <select id="currency" name="currency" required
                                class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('currency') border-red-500 @enderror">
                            <option value="INR" {{ old('currency', $settings['currency'] ?? 'INR') == 'INR' ? 'selected' : '' }}>INR (₹)</option>
                            <option value="USD" {{ old('currency', $settings['currency'] ?? 'INR') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                            <option value="EUR" {{ old('currency', $settings['currency'] ?? 'INR') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            <option value="GBP" {{ old('currency', $settings['currency'] ?? 'INR') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                        </select>
                        @error('currency')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tax Percentage -->
                    <div>
                        <label for="tax_percentage" class="block text-sm font-medium text-gray-300 mb-2">
                            Tax Percentage (%)
                        </label>
                        <input type="number" id="tax_percentage" name="tax_percentage" 
                               value="{{ old('tax_percentage', $settings['tax_percentage'] ?? 0) }}"
                               min="0" max="100" step="0.01"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('tax_percentage') border-red-500 @enderror"
                               placeholder="0.00">
                        @error('tax_percentage')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-gray-400 text-sm mt-1">GST/VAT percentage to be added to fees</p>
                    </div>
                </div>
            </div>

            <!-- Payment Status -->
            <div class="bg-gray-700/50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-white mb-3">Current Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold {{ env('RAZORPAY_KEY_ID') ? 'text-green-400' : 'text-red-400' }}">
                            {{ env('RAZORPAY_KEY_ID') ? 'Configured' : 'Not Set' }}
                        </div>
                        <div class="text-gray-400 text-sm">Razorpay Keys</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold {{ ($settings['payment_enabled'] ?? false) ? 'text-green-400' : 'text-yellow-400' }}">
                            {{ ($settings['payment_enabled'] ?? false) ? 'Enabled' : 'Disabled' }}
                        </div>
                        <div class="text-gray-400 text-sm">Payment Gateway</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-400">{{ $settings['currency'] ?? 'INR' }}</div>
                        <div class="text-gray-400 text-sm">Currency</div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition-all">
                    <i class="fas fa-save"></i>
                    <span>Save Payment Settings</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-400 mb-3">
            <i class="fas fa-info-circle mr-2"></i>
            Setup Instructions
        </h3>
        <div class="space-y-2 text-gray-300">
            <p>1. Create a Razorpay account at <a href="https://razorpay.com" target="_blank" class="text-blue-400 hover:underline">razorpay.com</a></p>
            <p>2. Get your API keys from the Razorpay Dashboard</p>
            <p>3. Set up webhooks to receive payment notifications</p>
            <p>4. Test payments in test mode before going live</p>
        </div>
    </div>
</div>
@endsection