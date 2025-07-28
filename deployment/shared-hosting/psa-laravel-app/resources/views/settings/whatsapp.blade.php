@extends('layouts.dashboard')

@section('title', 'WhatsApp Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">WhatsApp Settings</h1>
            <p class="text-gray-400 mt-1">Configure WhatsApp bot and notification settings</p>
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

    <!-- Bot Status -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-lg flex items-center justify-center">
                <i class="fab fa-whatsapp text-white"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Bot Status</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold {{ $botStatus['success'] ? 'text-green-400' : 'text-red-400' }}">
                    {{ $botStatus['success'] ? 'Online' : 'Offline' }}
                </div>
                <div class="text-gray-400 text-sm">Service Status</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold {{ isset($botStatus['data']['authenticated']) && $botStatus['data']['authenticated'] ? 'text-green-400' : 'text-yellow-400' }}">
                    {{ isset($botStatus['data']['authenticated']) && $botStatus['data']['authenticated'] ? 'Connected' : 'Disconnected' }}
                </div>
                <div class="text-gray-400 text-sm">WhatsApp Connection</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-400">{{ $botStatus['data']['messagesSent'] ?? 0 }}</div>
                <div class="text-gray-400 text-sm">Messages Sent</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-400">
                    {{ isset($botStatus['data']['lastActivity']) ? \Carbon\Carbon::parse($botStatus['data']['lastActivity'])->diffForHumans() : 'Never' }}
                </div>
                <div class="text-gray-400 text-sm">Last Activity</div>
            </div>
        </div>

        @if(isset($botStatus['data']['qrCode']) && $botStatus['data']['qrCode'] && !$botStatus['data']['authenticated'])
            <div class="mt-6 p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                <div class="flex items-center space-x-2 text-yellow-400 mb-2">
                    <i class="fas fa-qrcode"></i>
                    <span class="font-semibold">QR Code Required</span>
                </div>
                <p class="text-gray-300 text-sm">WhatsApp Web authentication required. Scan the QR code to connect.</p>
            </div>
        @endif
    </div>

    <!-- WhatsApp Configuration -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <form action="{{ route('settings.whatsapp.update') }}" method="POST" class="space-y-6">
            @csrf

            <!-- General Settings -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">General Settings</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- WhatsApp Enabled -->
                    <div class="md:col-span-2">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="whatsapp_enabled" value="1" 
                                   {{ old('whatsapp_enabled', $settings['whatsapp_enabled'] ?? false) ? 'checked' : '' }}
                                   class="w-5 h-5 text-green-600 bg-gray-700 border-gray-600 rounded focus:ring-green-500 focus:ring-2">
                            <span class="text-gray-300 font-medium">Enable WhatsApp Notifications</span>
                        </label>
                        <p class="text-gray-400 text-sm mt-1">Allow the system to send WhatsApp messages</p>
                    </div>

                    <!-- API URL -->
                    <div>
                        <label for="whatsapp_api_url" class="block text-sm font-medium text-gray-300 mb-2">
                            WhatsApp Bot API URL
                        </label>
                        <input type="url" id="whatsapp_api_url" name="whatsapp_api_url" 
                               value="{{ old('whatsapp_api_url', $settings['whatsapp_api_url'] ?? 'http://localhost:3001') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-transparent @error('whatsapp_api_url') border-red-500 @enderror"
                               placeholder="http://localhost:3001">
                        @error('whatsapp_api_url')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- API Token -->
                    <div>
                        <label for="whatsapp_api_token" class="block text-sm font-medium text-gray-300 mb-2">
                            API Token (Optional)
                        </label>
                        <input type="password" id="whatsapp_api_token" name="whatsapp_api_token" 
                               value="{{ old('whatsapp_api_token', $settings['whatsapp_api_token'] ?? '') }}"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-green-500 focus:border-transparent @error('whatsapp_api_token') border-red-500 @enderror"
                               placeholder="Your API token">
                        @error('whatsapp_api_token')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Fee Reminders -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-money-bill text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Fee Reminders</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Fee Reminder Enabled -->
                    <div class="md:col-span-2">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="fee_reminder_enabled" value="1" 
                                   {{ old('fee_reminder_enabled', $settings['fee_reminder_enabled'] ?? false) ? 'checked' : '' }}
                                   class="w-5 h-5 text-red-600 bg-gray-700 border-gray-600 rounded focus:ring-red-500 focus:ring-2">
                            <span class="text-gray-300 font-medium">Enable Fee Reminders</span>
                        </label>
                        <p class="text-gray-400 text-sm mt-1">Send automatic fee payment reminders to students</p>
                    </div>

                    <!-- Reminder Days -->
                    <div>
                        <label for="fee_reminder_days" class="block text-sm font-medium text-gray-300 mb-2">
                            Reminder Days Before Due Date
                        </label>
                        <input type="number" id="fee_reminder_days" name="fee_reminder_days" 
                               value="{{ old('fee_reminder_days', $settings['fee_reminder_days'] ?? 3) }}"
                               min="1" max="30"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent @error('fee_reminder_days') border-red-500 @enderror"
                               placeholder="3">
                        @error('fee_reminder_days')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Session Notifications -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-white"></i>
                    </div>
                    <h2 class="text-xl font-bold text-white">Session Notifications</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Session Reminder Enabled -->
                    <div class="md:col-span-2">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="session_reminder_enabled" value="1" 
                                   {{ old('session_reminder_enabled', $settings['session_reminder_enabled'] ?? false) ? 'checked' : '' }}
                                   class="w-5 h-5 text-purple-600 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                            <span class="text-gray-300 font-medium">Enable Session Reminders</span>
                        </label>
                        <p class="text-gray-400 text-sm mt-1">Send session reminders to students before training</p>
                    </div>

                    <!-- Reminder Hours -->
                    <div>
                        <label for="session_reminder_hours" class="block text-sm font-medium text-gray-300 mb-2">
                            Reminder Hours Before Session
                        </label>
                        <input type="number" id="session_reminder_hours" name="session_reminder_hours" 
                               value="{{ old('session_reminder_hours', $settings['session_reminder_hours'] ?? 2) }}"
                               min="1" max="24"
                               class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('session_reminder_hours') border-red-500 @enderror"
                               placeholder="2">
                        @error('session_reminder_hours')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attendance Notifications -->
                    <div>
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="attendance_notification_enabled" value="1" 
                                   {{ old('attendance_notification_enabled', $settings['attendance_notification_enabled'] ?? false) ? 'checked' : '' }}
                                   class="w-5 h-5 text-purple-600 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
                            <span class="text-gray-300 font-medium">Attendance Notifications</span>
                        </label>
                        <p class="text-gray-400 text-sm mt-1">Notify parents about attendance</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-2 rounded-lg flex items-center space-x-2 transition-all">
                    <i class="fas fa-save"></i>
                    <span>Save WhatsApp Settings</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Test Message -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-lg flex items-center justify-center">
                <i class="fas fa-paper-plane text-white"></i>
            </div>
            <h2 class="text-xl font-bold text-white">Test Message</h2>
        </div>

        <form action="{{ route('whatsapp.test') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="test_phone" class="block text-sm font-medium text-gray-300 mb-2">
                        Phone Number
                    </label>
                    <input type="tel" id="test_phone" name="phone" required
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                           placeholder="+91 9876543210">
                </div>
                <div>
                    <label for="test_message" class="block text-sm font-medium text-gray-300 mb-2">
                        Test Message
                    </label>
                    <input type="text" id="test_message" name="message" required
                           value="Hello! This is a test message from PSA Sports Academy."
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 text-white placeholder-gray-400 focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-all">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Test Message</span>
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
            <p>1. Ensure the WhatsApp bot service is running on the configured URL</p>
            <p>2. Scan the QR code with WhatsApp to authenticate the bot</p>
            <p>3. Enable the desired notification types</p>
            <p>4. Test the connection using the test message feature</p>
        </div>
    </div>
</div>
@endsection