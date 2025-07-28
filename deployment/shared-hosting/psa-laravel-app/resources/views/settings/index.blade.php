@extends('layouts.dashboard')

@section('title', 'System Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">System Settings</h1>
            <p class="text-gray-400 mt-1">Configure and manage your academy system</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="clearCache()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-broom mr-2"></i>
                Clear Cache
            </button>
            <button onclick="createBackup()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-download mr-2"></i>
                Create Backup
            </button>
        </div>
    </div>

    <!-- System Status -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">System Status</p>
                    <p class="text-2xl font-bold text-green-400">Online</p>
                    <p class="text-gray-400 text-sm">{{ $settings['app_env'] }} mode</p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-lg">
                    <i class="fas fa-server text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Database</p>
                    <p class="text-2xl font-bold text-blue-400">Connected</p>
                    <p class="text-gray-400 text-sm">{{ $settings['db_database'] }}</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-lg">
                    <i class="fas fa-database text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">WhatsApp Bot</p>
                    <p class="text-2xl font-bold text-{{ $settings['whatsapp_enabled'] ? 'green' : 'red' }}-400">
                        {{ $settings['whatsapp_enabled'] ? 'Enabled' : 'Disabled' }}
                    </p>
                    <p class="text-gray-400 text-sm">Notifications</p>
                </div>
                <div class="bg-{{ $settings['whatsapp_enabled'] ? 'green' : 'red' }}-500/20 p-3 rounded-lg">
                    <i class="fab fa-whatsapp text-{{ $settings['whatsapp_enabled'] ? 'green' : 'red' }}-400 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm">Debug Mode</p>
                    <p class="text-2xl font-bold text-{{ $settings['app_debug'] ? 'yellow' : 'green' }}-400">
                        {{ $settings['app_debug'] ? 'On' : 'Off' }}
                    </p>
                    <p class="text-gray-400 text-sm">{{ $settings['app_debug'] ? 'Development' : 'Production' }}</p>
                </div>
                <div class="bg-{{ $settings['app_debug'] ? 'yellow' : 'green' }}-500/20 p-3 rounded-lg">
                    <i class="fas fa-bug text-{{ $settings['app_debug'] ? 'yellow' : 'green' }}-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- General Settings -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-purple-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-cog text-purple-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">General Settings</h3>
                    <p class="text-gray-400 text-sm">Basic application configuration</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-300">
                    <p><span class="text-gray-400">App Name:</span> {{ $settings['app_name'] }}</p>
                    <p><span class="text-gray-400">Timezone:</span> {{ $settings['timezone'] }}</p>
                    <p><span class="text-gray-400">Currency:</span> {{ $settings['currency'] }}</p>
                </div>
                <a href="{{ route('settings.general') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Configure General Settings
                </a>
            </div>
        </div>

        <!-- Database Settings -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-blue-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-database text-blue-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Database Settings</h3>
                    <p class="text-gray-400 text-sm">Database connection and management</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-300">
                    <p><span class="text-gray-400">Host:</span> {{ $settings['db_host'] }}</p>
                    <p><span class="text-gray-400">Database:</span> {{ $settings['db_database'] }}</p>
                    <p><span class="text-gray-400">Port:</span> {{ $settings['db_port'] }}</p>
                </div>
                <a href="{{ route('settings.database') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Configure Database
                </a>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-green-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-envelope text-green-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Email Settings</h3>
                    <p class="text-gray-400 text-sm">SMTP and email configuration</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-300">
                    <p><span class="text-gray-400">Mailer:</span> {{ $settings['mail_mailer'] }}</p>
                    <p><span class="text-gray-400">From:</span> {{ $settings['mail_from_address'] }}</p>
                    <p><span class="text-gray-400">Host:</span> {{ $settings['mail_host'] ?? 'Not configured' }}</p>
                </div>
                <a href="{{ route('settings.email') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Configure Email
                </a>
            </div>
        </div>

        <!-- WhatsApp Settings -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-green-500/20 p-3 rounded-lg mr-4">
                    <i class="fab fa-whatsapp text-green-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">WhatsApp Settings</h3>
                    <p class="text-gray-400 text-sm">Bot configuration and notifications</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-300">
                    <p><span class="text-gray-400">Status:</span> {{ $settings['whatsapp_enabled'] ? 'Enabled' : 'Disabled' }}</p>
                    <p><span class="text-gray-400">Fee Reminders:</span> {{ $settings['fee_reminder_enabled'] ? 'On' : 'Off' }}</p>
                    <p><span class="text-gray-400">Attendance:</span> {{ $settings['attendance_notification_enabled'] ? 'On' : 'Off' }}</p>
                </div>
                <a href="{{ route('settings.whatsapp') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Configure WhatsApp
                </a>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-blue-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-credit-card text-blue-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Payment Settings</h3>
                    <p class="text-gray-400 text-sm">Payment gateway configuration</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-300">
                    <p><span class="text-gray-400">Gateway:</span> {{ env('RAZORPAY_KEY_ID') ? 'Razorpay' : 'Not Configured' }}</p>
                    <p><span class="text-gray-400">Status:</span> {{ ($settings['payment_enabled'] ?? false) ? 'Enabled' : 'Disabled' }}</p>
                    <p><span class="text-gray-400">Currency:</span> {{ $settings['currency'] ?? 'INR' }}</p>
                </div>
                <a href="{{ route('settings.payment') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Configure Payments
                </a>
            </div>
        </div>

        <!-- Backup & Restore -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-yellow-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-download text-yellow-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Backup & Restore</h3>
                    <p class="text-gray-400 text-sm">Data backup and recovery</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-300">
                    <p><span class="text-gray-400">Last Backup:</span> {{ date('M d, Y') }}</p>
                    <p><span class="text-gray-400">Auto Backup:</span> Enabled</p>
                    <p><span class="text-gray-400">Storage:</span> Local</p>
                </div>
                <a href="{{ route('settings.backup') }}" class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Manage Backups
                </a>
            </div>
        </div>

        <!-- Cache Management -->
        <div class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-purple-500 transition-colors">
            <div class="flex items-center mb-4">
                <div class="bg-red-500/20 p-3 rounded-lg mr-4">
                    <i class="fas fa-memory text-red-400 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">Cache Management</h3>
                    <p class="text-gray-400 text-sm">Performance optimization</p>
                </div>
            </div>
            <div class="space-y-3">
                <div class="text-sm text-gray-300">
                    <p><span class="text-gray-400">Config Cache:</span> Active</p>
                    <p><span class="text-gray-400">Route Cache:</span> Active</p>
                    <p><span class="text-gray-400">View Cache:</span> Active</p>
                </div>
                <a href="{{ route('settings.cache') }}" class="block w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                    Manage Cache
                </a>
            </div>
        </div>
    </div>

    <!-- System Information -->
    <div class="bg-gray-800 rounded-xl p-6 border border-gray-700">
        <h2 class="text-xl font-semibold text-white mb-6">System Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-400">{{ PHP_VERSION }}</div>
                <div class="text-gray-400 text-sm">PHP Version</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-400">{{ app()->version() }}</div>
                <div class="text-gray-400 text-sm">Laravel Version</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-400">{{ round(memory_get_usage() / 1024 / 1024, 2) }}MB</div>
                <div class="text-gray-400 text-sm">Memory Usage</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-400">{{ date('M d, Y') }}</div>
                <div class="text-gray-400 text-sm">Last Updated</div>
            </div>
        </div>
    </div>
</div>

<script>
function clearCache() {
    if (confirm('Are you sure you want to clear all caches? This may temporarily slow down the application.')) {
        fetch('{{ route("settings.cache.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cache cleared successfully!');
                location.reload();
            } else {
                alert('Failed to clear cache: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}

function createBackup() {
    if (confirm('Create a new database backup? This may take a few minutes.')) {
        fetch('{{ route("settings.backup.create") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Backup created successfully!');
                location.reload();
            } else {
                alert('Failed to create backup: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}
</script>
@endsection