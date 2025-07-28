<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PSA Sports Academy') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Custom Blue Dark Theme Styles */
        :root {
            --primary-blue: #3B82F6;
            --primary-blue-dark: #2563EB;
            --secondary-blue: #60A5FA;
            --accent-blue: #1D4ED8;
            --dark-bg: #0F172A;
            --dark-surface: #1E293B;
            --dark-surface-light: #334155;
            --dark-border: #475569;
            --sidebar-bg: #1E293B;
            --sidebar-hover: #334155;
            --text-primary: #F8FAFC;
            --text-secondary: #CBD5E1;
            --text-muted: #94A3B8;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
        }

        body {
            background-color: var(--dark-bg);
            color: var(--text-primary);
        }

        .sidebar {
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1a202c 100%);
            border-right: 1px solid var(--dark-border);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .nav-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 8px;
            margin: 2px 8px;
        }

        .nav-item:hover {
            background-color: var(--sidebar-hover);
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.15);
        }

        .nav-item.active {
            background: linear-gradient(90deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
            border-left: 4px solid var(--primary-blue);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .card {
            background-color: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
        }

        .card-gradient {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-blue) 100%);
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
            border: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--dark-surface) 0%, var(--dark-surface-light) 100%);
            border-left: 4px solid var(--primary-blue);
            border-radius: 12px;
        }

        .table-dark {
            background-color: var(--dark-surface);
            border-color: var(--dark-border);
        }

        .table-dark th,
        .table-dark td {
            border-color: var(--dark-border);
            color: var(--text-primary);
        }

        .badge-success {
            background-color: var(--success);
        }

        .badge-warning {
            background-color: var(--warning);
        }

        .badge-danger {
            background-color: var(--danger);
        }

        .badge-info {
            background-color: var(--primary-blue);
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle {
            background: var(--dark-surface);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 4px;
            transition: all 0.3s ease;
        }

        .dark-mode-toggle:hover {
            background: var(--dark-surface-light);
        }

        /* Improved spacing and layout */
        .main-content {
            background: var(--dark-bg);
            min-height: 100vh;
        }

        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Professional card styling */
        .metric-card {
            background: linear-gradient(135deg, var(--dark-surface) 0%, var(--dark-surface-light) 100%);
            border: 1px solid var(--dark-border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu {
            background-color: var(--dark-surface);
            border: 1px solid var(--dark-border);
        }

        .dropdown-item {
            color: var(--text-primary);
        }

        .dropdown-item:hover {
            background-color: var(--dark-surface-light);
            color: var(--text-primary);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen lg:flex">
        <!-- Mobile menu overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar w-64 min-h-screen fixed left-0 top-0 z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:static lg:transform-none lg:flex-shrink-0">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center p-1">
                        <!-- PSA Logo SVG -->
                        <svg viewBox="0 0 100 100" class="w-full h-full">
                            <!-- P -->
                            <rect x="10" y="20" width="8" height="60" fill="#2D4A87"/>
                            <rect x="18" y="20" width="20" height="8" fill="#2D4A87"/>
                            <rect x="30" y="28" width="8" height="12" fill="#2D4A87"/>
                            <rect x="18" y="40" width="20" height="8" fill="#2D4A87"/>
                            
                            <!-- S -->
                            <rect x="45" y="20" width="20" height="8" fill="#2D4A87"/>
                            <rect x="45" y="28" width="8" height="12" fill="#2D4A87"/>
                            <rect x="45" y="40" width="20" height="8" fill="#2D4A87"/>
                            <rect x="57" y="48" width="8" height="12" fill="#2D4A87"/>
                            <rect x="45" y="60" width="20" height="8" fill="#2D4A87"/>
                            
                            <!-- A -->
                            <polygon points="75,80 82,20 90,80" fill="#7DD3FC"/>
                            <rect x="77" y="45" width="11" height="6" fill="#7DD3FC"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Parmanand</h1>
                        <p class="text-sm text-gray-400">Sports Academy</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('dashboard') ? 'active text-white' : '' }}">
                        <i class="fas fa-tachometer-alt w-5"></i>
                        <span>Dashboard</span>
                    </a>

                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('coach'))
                    <a href="{{ route('students.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('students.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-users w-5"></i>
                        <span>Students</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('fees.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('fees.*') ? 'active text-white' : '' }}">
                        <i class="fas fa-money-bill-wave w-5"></i>
                        <span>Fee Management</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('coaches.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('coaches.*') ? 'bg-purple-600 text-white' : '' }}">
                        <i class="fas fa-user-tie w-5"></i>
                        <span>Coaches</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('sports.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('sports.*') || request()->routeIs('batches.*') ? 'bg-purple-600 text-white' : '' }}">
                        <i class="fas fa-futbol w-5"></i>
                        <span>Sports & Batches</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('payments.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('payments.*') ? 'bg-purple-600 text-white' : '' }}">
                        <i class="fas fa-credit-card w-5"></i>
                        <span>Payments</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('coach'))
                    <a href="{{ route('attendance.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('attendance.*') ? 'bg-purple-600 text-white' : '' }}">
                        <i class="fas fa-calendar-check w-5"></i>
                        <span>Attendance</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('inquiries.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('inquiries.*') ? 'bg-purple-600 text-white' : '' }}">
                        <i class="fas fa-question-circle w-5"></i>
                        <span>Inquiries</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('whatsapp.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white {{ request()->routeIs('whatsapp.*') ? 'bg-purple-600 text-white' : '' }}">
                        <i class="fab fa-whatsapp w-5"></i>
                        <span>WhatsApp</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('reports.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-chart-bar w-5"></i>
                        <span>Reports</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="#" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-certificate w-5"></i>
                        <span>Certificates</span>
                    </a>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('settings.index') }}" class="nav-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 lg:flex-1 min-w-0 main-content">
            <!-- Top Navigation -->
            <header class="bg-slate-800 border-b border-slate-700 px-4 lg:px-6 py-4 sticky top-0 z-20">
                <div class="content-wrapper">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Mobile menu toggle -->
                            <button id="mobile-menu-toggle" class="lg:hidden p-2 text-gray-400 hover:text-white rounded-lg hover:bg-slate-700 transition-colors relative z-50">
                                <i class="fas fa-bars text-lg"></i>
                            </button>
                            
                            <div>
                                <h2 class="text-xl lg:text-2xl font-bold text-white">@yield('page-title', 'Dashboard')</h2>
                                <p class="text-gray-400 text-sm hidden sm:block">@yield('page-description', 'Welcome to PSA Sports Academy Management')</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2 lg:space-x-4">
                            <!-- Dark Mode Toggle -->
                            <div class="dark-mode-toggle">
                                <button id="theme-toggle" class="p-2 text-gray-400 hover:text-white rounded-full transition-colors">
                                    <i class="fas fa-moon text-sm"></i>
                                </button>
                            </div>

                            <!-- Notifications -->
                            <div class="relative">
                                <button class="p-2 text-gray-400 hover:text-white rounded-lg hover:bg-slate-700 transition-colors">
                                    <i class="fas fa-bell text-lg"></i>
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                                </button>
                            </div>

                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-slate-700 transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="text-left hidden sm:block">
                                        <p class="text-white text-sm font-medium">{{ Auth::user()->name }}</p>
                                        <p class="text-gray-400 text-xs capitalize">{{ Auth::user()->role }}</p>
                                    </div>
                                    <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-lg border border-slate-700 py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 px-4 py-2 text-gray-300 hover:text-white hover:bg-slate-700">
                                        <i class="fas fa-user w-4"></i>
                                        <span>Profile</span>
                                    </a>
                                    <div class="border-t border-slate-700 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center space-x-2 px-4 py-2 text-gray-300 hover:text-white hover:bg-slate-700 w-full text-left">
                                            <i class="fas fa-sign-out-alt w-4"></i>
                                            <span>Log Out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 lg:p-6">
                <div class="content-wrapper">
                    @if (session('success'))
                        <div class="mb-6 bg-green-800 border border-green-700 text-green-100 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-800 border border-red-700 text-red-100 px-4 py-3 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            const themeToggle = document.getElementById('theme-toggle');
            
            function toggleMobileMenu() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
            
            function closeMobileMenu() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
            
            // Toggle menu when button is clicked
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', toggleMobileMenu);
            }
            
            // Close menu when overlay is clicked
            if (overlay) {
                overlay.addEventListener('click', closeMobileMenu);
            }
            
            // Close menu when window is resized to desktop size
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) { // lg breakpoint
                    closeMobileMenu();
                }
            });
            
            // Close menu when a navigation link is clicked on mobile
            const navLinks = sidebar.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeMobileMenu();
                    }
                });
            });

            // Dark mode toggle functionality
            if (themeToggle) {
                const icon = themeToggle.querySelector('i');
                let isDark = localStorage.getItem('theme') === 'dark' || 
                           (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                function updateTheme() {
                    if (isDark) {
                        document.documentElement.classList.add('dark');
                        icon.className = 'fas fa-sun text-sm';
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        icon.className = 'fas fa-moon text-sm';
                        localStorage.setItem('theme', 'light');
                    }
                }
                
                // Initialize theme
                updateTheme();
                
                themeToggle.addEventListener('click', function() {
                    isDark = !isDark;
                    updateTheme();
                });
            }

            // Add smooth scrolling to navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading states to buttons
            document.querySelectorAll('button[type="submit"], .btn-primary').forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.disabled) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
                        this.disabled = true;
                        
                        // Re-enable after 3 seconds (fallback)
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                        }, 3000);
                    }
                });
            });
        });
    </script>
</body>
</html>