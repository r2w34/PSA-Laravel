<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSA Sports Academy - Installation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        purple: {
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-900 text-white min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-gray-800 border-b border-gray-700">
            <div class="max-w-4xl mx-auto px-4 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">PSA Sports Academy</h1>
                            <p class="text-sm text-gray-400">Installation Wizard</p>
                        </div>
                    </div>
                    <div class="text-sm text-gray-400">
                        Step @yield('step', '1') of 6
                    </div>
                </div>
            </div>
        </header>

        <!-- Progress Bar -->
        <div class="bg-gray-800 border-b border-gray-700">
            <div class="max-w-4xl mx-auto px-4 py-2">
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full transition-all duration-300" style="width: @yield('progress', '16')%"></div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center p-4">
            <div class="w-full max-w-2xl">
                <div class="bg-gray-800 rounded-lg shadow-xl border border-gray-700">
                    <div class="p-8">
                        @if(session('error'))
                            <div class="mb-6 bg-red-900/50 border border-red-700 text-red-200 px-4 py-3 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="mb-6 bg-green-900/50 border border-green-700 text-green-200 px-4 py-3 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 border-t border-gray-700">
            <div class="max-w-4xl mx-auto px-4 py-4">
                <p class="text-center text-sm text-gray-400">
                    © {{ date('Y') }} PSA Sports Academy Management System
                </p>
            </div>
        </footer>
    </div>
</body>
</html>