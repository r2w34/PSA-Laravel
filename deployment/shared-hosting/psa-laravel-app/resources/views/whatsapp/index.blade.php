@extends('layouts.dashboard')

@section('title', 'WhatsApp Management')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-white">WhatsApp Management</h1>
                <p class="text-gray-400 mt-1">Manage WhatsApp bot and send automated messages</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="testConnection()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-wifi mr-2"></i>Test Connection
                </button>
                <button onclick="refreshStatus()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh Status
                </button>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Bot Status -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Bot Status</h3>
                        <p id="bot-status" class="text-gray-400 mt-1">
                            @if($isAvailable)
                                <span class="text-green-400"><i class="fas fa-check-circle mr-1"></i>Online</span>
                            @else
                                <span class="text-red-400"><i class="fas fa-times-circle mr-1"></i>Offline</span>
                            @endif
                        </p>
                    </div>
                    <div class="text-3xl">
                        <i class="fab fa-whatsapp {{ $isAvailable ? 'text-green-400' : 'text-red-400' }}"></i>
                    </div>
                </div>
            </div>

            <!-- Session Status -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Session</h3>
                        <p id="session-status" class="text-gray-400 mt-1">
                            @if($status['success'] ?? false)
                                @if($status['data']['session_exists'] ?? false)
                                    <span class="text-green-400"><i class="fas fa-check-circle mr-1"></i>Active</span>
                                @else
                                    <span class="text-yellow-400"><i class="fas fa-exclamation-triangle mr-1"></i>Not Authenticated</span>
                                @endif
                            @else
                                <span class="text-gray-400">Unknown</span>
                            @endif
                        </p>
                    </div>
                    <div class="text-3xl">
                        <i class="fas fa-mobile-alt text-purple-400"></i>
                    </div>
                </div>
            </div>

            <!-- Queue Status -->
            <div class="bg-gray-800 rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white">Message Queue</h3>
                        <p id="queue-status" class="text-gray-400 mt-1">
                            {{ $status['data']['message_queue_size'] ?? 0 }} messages
                        </p>
                    </div>
                    <div class="text-3xl">
                        <i class="fas fa-list text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div id="qr-section" class="bg-gray-800 rounded-lg p-6" style="display: none;">
            <h3 class="text-lg font-semibold text-white mb-4">WhatsApp Authentication</h3>
            <div class="text-center">
                <div id="qr-code" class="mb-4"></div>
                <p class="text-gray-400">Scan this QR code with your WhatsApp mobile app</p>
                <button onclick="getQRCode()" class="mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-qrcode mr-2"></i>Get QR Code
                </button>
            </div>
        </div>

        <!-- Action Tabs -->
        <div class="bg-gray-800 rounded-lg">
            <div class="border-b border-gray-700">
                <nav class="flex space-x-8 px-6">
                    <button onclick="showTab('send-message')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-400 hover:text-white hover:border-purple-400 transition-colors active">
                        <i class="fas fa-paper-plane mr-2"></i>Send Message
                    </button>
                    <button onclick="showTab('fee-reminders')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-400 hover:text-white hover:border-purple-400 transition-colors">
                        <i class="fas fa-money-bill mr-2"></i>Fee Reminders
                    </button>
                    <button onclick="showTab('session-notifications')" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-400 hover:text-white hover:border-purple-400 transition-colors">
                        <i class="fas fa-calendar mr-2"></i>Session Notifications
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- Send Message Tab -->
                <div id="send-message-tab" class="tab-content">
                    <h3 class="text-lg font-semibold text-white mb-4">Send Custom Message</h3>
                    <form id="send-message-form" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                            <input type="text" id="message-phone" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="+91XXXXXXXXXX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                            <textarea id="message-text" rows="4" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent" placeholder="Enter your message here..."></textarea>
                        </div>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i>Send Message
                        </button>
                    </form>
                </div>

                <!-- Fee Reminders Tab -->
                <div id="fee-reminders-tab" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-white mb-4">Fee Reminders</h3>
                    <div class="space-y-4">
                        <button onclick="loadOutstandingFees()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search mr-2"></i>Load Students with Outstanding Fees
                        </button>
                        
                        <div id="outstanding-fees-list" class="hidden">
                            <div class="bg-gray-700 rounded-lg p-4 mb-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-white font-medium">Students with Outstanding Fees</h4>
                                    <button onclick="sendBulkFeeReminders()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                                        <i class="fas fa-paper-plane mr-2"></i>Send All Reminders
                                    </button>
                                </div>
                                <div id="outstanding-fees-table" class="overflow-x-auto">
                                    <!-- Table will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Session Notifications Tab -->
                <div id="session-notifications-tab" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-white mb-4">Session Notifications</h3>
                    <div class="space-y-4">
                        <button onclick="loadBatches()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-search mr-2"></i>Load Active Batches
                        </button>
                        
                        <div id="batches-list" class="hidden">
                            <div class="bg-gray-700 rounded-lg p-4">
                                <h4 class="text-white font-medium mb-4">Active Batches</h4>
                                <div id="batches-table" class="overflow-x-auto">
                                    <!-- Table will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loading-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-gray-800 rounded-lg p-6 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-500 mx-auto mb-4"></div>
            <p class="text-white">Processing...</p>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-purple-400', 'text-white');
                button.classList.add('text-gray-400');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Add active class to selected button
            event.target.classList.add('active', 'border-purple-400', 'text-white');
            event.target.classList.remove('text-gray-400');
        }

        // Status functions
        function refreshStatus() {
            fetch('{{ route("whatsapp.status") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateStatusDisplay(data.data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to refresh status', 'error');
                });
        }

        function testConnection() {
            showLoading();
            fetch('{{ route("whatsapp.test-connection") }}')
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        showNotification('WhatsApp bot is connected and ready!', 'success');
                    } else {
                        showNotification('WhatsApp bot is not available: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    showNotification('Connection test failed', 'error');
                });
        }

        function updateStatusDisplay(statusData) {
            // Update bot status
            const botStatusEl = document.getElementById('bot-status');
            if (statusData.available) {
                botStatusEl.innerHTML = '<span class="text-green-400"><i class="fas fa-check-circle mr-1"></i>Online</span>';
            } else {
                botStatusEl.innerHTML = '<span class="text-red-400"><i class="fas fa-times-circle mr-1"></i>Offline</span>';
            }

            // Update session status
            const sessionStatusEl = document.getElementById('session-status');
            if (statusData.status.success && statusData.status.data.session_exists) {
                sessionStatusEl.innerHTML = '<span class="text-green-400"><i class="fas fa-check-circle mr-1"></i>Active</span>';
            } else {
                sessionStatusEl.innerHTML = '<span class="text-yellow-400"><i class="fas fa-exclamation-triangle mr-1"></i>Not Authenticated</span>';
                document.getElementById('qr-section').style.display = 'block';
            }

            // Update queue status
            const queueStatusEl = document.getElementById('queue-status');
            queueStatusEl.textContent = (statusData.status.data.message_queue_size || 0) + ' messages';
        }

        // Send message functionality
        document.getElementById('send-message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const phone = document.getElementById('message-phone').value;
            const message = document.getElementById('message-text').value;
            
            if (!phone || !message) {
                showNotification('Please fill in all fields', 'error');
                return;
            }

            showLoading();
            
            fetch('{{ route("whatsapp.send-message") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    phone: phone,
                    message: message
                })
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showNotification('Message sent successfully!', 'success');
                    document.getElementById('send-message-form').reset();
                } else {
                    showNotification('Failed to send message: ' + data.message, 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showNotification('Failed to send message', 'error');
            });
        });

        // Fee reminders functionality
        function loadOutstandingFees() {
            showLoading();
            
            fetch('{{ route("whatsapp.outstanding-fee-students") }}')
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        displayOutstandingFees(data.data);
                        document.getElementById('outstanding-fees-list').classList.remove('hidden');
                    } else {
                        showNotification('Failed to load outstanding fees', 'error');
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    showNotification('Failed to load outstanding fees', 'error');
                });
        }

        function displayOutstandingFees(students) {
            const tableContainer = document.getElementById('outstanding-fees-table');
            
            if (students.length === 0) {
                tableContainer.innerHTML = '<p class="text-gray-400 text-center py-4">No students with outstanding fees found.</p>';
                return;
            }

            let tableHTML = `
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-600">
                            <th class="text-left py-2 text-gray-300">Student</th>
                            <th class="text-left py-2 text-gray-300">Phone</th>
                            <th class="text-left py-2 text-gray-300">Sport</th>
                            <th class="text-left py-2 text-gray-300">Amount</th>
                            <th class="text-left py-2 text-gray-300">Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            students.forEach(student => {
                tableHTML += `
                    <tr class="border-b border-gray-700">
                        <td class="py-2 text-white">${student.name}</td>
                        <td class="py-2 text-gray-300">${student.phone || 'N/A'}</td>
                        <td class="py-2 text-gray-300">${student.sport}</td>
                        <td class="py-2 text-green-400">₹${student.outstanding_amount}</td>
                        <td class="py-2">
                            <button onclick="sendFeeReminder(${student.id})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs transition-colors">
                                Send Reminder
                            </button>
                        </td>
                    </tr>
                `;
            });

            tableHTML += '</tbody></table>';
            tableContainer.innerHTML = tableHTML;
        }

        function sendFeeReminder(studentId) {
            showLoading();
            
            fetch('{{ route("whatsapp.send-fee-reminder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    student_id: studentId
                })
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showNotification('Fee reminder sent successfully!', 'success');
                } else {
                    showNotification('Failed to send fee reminder: ' + data.message, 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showNotification('Failed to send fee reminder', 'error');
            });
        }

        // Utility functions
        function showLoading() {
            document.getElementById('loading-modal').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loading-modal').classList.add('hidden');
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 5 seconds
            setTimeout(() => {
                notification.remove();
            }, 5000);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Check if bot needs authentication
            @if(!($status['success'] ?? false) || !($status['data']['session_exists'] ?? false))
                document.getElementById('qr-section').style.display = 'block';
            @endif
        });
    </script>
@endsection