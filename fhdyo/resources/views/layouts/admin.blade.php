<!DOCTYPE html>
<html lang="uz" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Nikoh Testi Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-slate-50 text-slate-800 font-sans antialiased">
    <div class="min-h-full flex">
        <!-- Sidebar - Desktop (Hidden on mobile) -->
        <aside id="sidebar" class="hidden lg:block w-72 bg-white flex-shrink-0 sticky top-0 h-screen overflow-y-auto shadow-[0_8px_30px_rgb(0,0,0,0.04)] z-40 transition-all duration-300">
            <!-- Logo Section -->
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-900">Nikoh Testi</h1>
                        <p class="text-xs text-slate-500">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:shadow-sm' }} flex items-center justify-center mr-3 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                        <div class="ml-auto w-1 h-6 bg-indigo-600 rounded-full"></div>
                    @endif
                </a>
                
                <!-- Bo'limlar -->
                <a href="{{ route('admin.units.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.units.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.units.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:shadow-sm' }} flex items-center justify-center mr-3 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Bo'limlar</span>
                    @if(request()->routeIs('admin.units.*'))
                        <div class="ml-auto w-1 h-6 bg-indigo-600 rounded-full"></div>
                    @endif
                </a>
                
                <!-- Savollar -->
                <a href="{{ route('admin.questions.manage') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.questions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.questions.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:shadow-sm' }} flex items-center justify-center mr-3 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Savollar</span>
                    @if(request()->routeIs('admin.questions.*'))
                        <div class="ml-auto w-1 h-6 bg-indigo-600 rounded-full"></div>
                    @endif
                </a>
                
                <!-- Foydalanuvchilar -->
                <a href="{{ route('admin.users.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:shadow-sm' }} flex items-center justify-center mr-3 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Foydalanuvchilar</span>
                    @if(request()->routeIs('admin.users.*'))
                        <div class="ml-auto w-1 h-6 bg-indigo-600 rounded-full"></div>
                    @endif
                </a>
                
                <!-- Juftliklar -->
                <a href="{{ route('admin.test-sessions.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.test-sessions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.test-sessions.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:shadow-sm' }} flex items-center justify-center mr-3 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Juftliklar</span>
                    @if(request()->routeIs('admin.test-sessions.*'))
                        <div class="ml-auto w-1 h-6 bg-indigo-600 rounded-full"></div>
                    @endif
                </a>
                
                @if(auth('admin')->user()->is_super_admin)
                <!-- Super Admin Section -->
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Super Admin</p>
                    <a href="{{ route('admin.super.admins.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.super.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.super.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500 group-hover:bg-white group-hover:shadow-sm' }} flex items-center justify-center mr-3 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.402.645l.985 2.346c.18.434.03.936-.387 1.17l-1.087.63c-.383.221-.62.632-.62 1.078v.803c0 .444.237.855.62 1.076l1.087.63c.417.242.567.737.387 1.171l-.985 2.345a1.125 1.125 0 01-1.402.645l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.402-.645l-.985-2.346c-.18-.434-.03-.936.387-1.17l1.087-.63c.383-.221.62-.632.62-1.078v-.803c0-.444-.237-.855-.62-1.076l-1.087-.63a1.125 1.125 0 01-.387-1.171l.985-2.345a1.125 1.125 0 011.402-.645l1.217.456c.355.133.75.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.869l.213-1.281z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">Adminlar</span>
                        @if(request()->routeIs('admin.super.*'))
                            <div class="ml-auto w-1 h-6 bg-indigo-600 rounded-full"></div>
                        @endif
                    </a>
                </div>
                @endif
            </nav>
            
            <!-- Admin Profile Card -->
            <div class="p-4 mt-auto">
                <div class="bg-slate-50 rounded-2xl p-4">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-indigo-200">
                            {{ substr(auth('admin')->user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">{{ auth('admin')->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ auth('admin')->user()->username }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-600 bg-white rounded-xl hover:bg-slate-100 hover:text-slate-900 transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"></path>
                            </svg>
                            Chiqish
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Mobile Sidebar Overlay -->
        <div id="mobileOverlay" class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleMobileMenu()"></div>
        
        <!-- Mobile Sidebar -->
        <aside id="mobileSidebar" class="fixed inset-y-0 left-0 w-72 bg-white flex-shrink-0 h-screen overflow-y-auto shadow-2xl z-50 transform -translate-x-full lg:hidden transition-transform duration-300">
            <!-- Same content as desktop sidebar - Mobile version -->
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-slate-900">Nikoh Testi</h1>
                            <p class="text-xs text-slate-500">Admin Panel</p>
                        </div>
                    </div>
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-xl hover:bg-slate-100">
                        <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.units.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.units.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.units.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Bo'limlar</span>
                </a>
                
                <a href="{{ route('admin.questions.manage') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.questions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.questions.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Savollar</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Foydalanuvchilar</span>
                </a>
                
                <a href="{{ route('admin.test-sessions.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.test-sessions.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                    <div class="w-8 h-8 rounded-xl {{ request()->routeIs('admin.test-sessions.*') ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Juftliklar</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Header -->
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30">
                <div class="h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                        </svg>
                    </button>
                    
                    <!-- Page Title -->
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-bold text-slate-900 hidden sm:block">{{ $title ?? 'Dashboard' }}</h2>
                        <h2 class="text-lg font-bold text-slate-900 sm:hidden">{{ $title ?? 'Dashboard' }}</h2>
                    </div>
                    
                    <!-- Right Actions -->
                    <div class="flex items-center gap-2 sm:gap-4">
                        <a href="{{ route('user.entry') }}" target="_blank" class="hidden sm:flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
                            </svg>
                            Saytga o'tish
                        </a>
                        <a href="{{ route('user.entry') }}" target="_blank" class="sm:hidden p-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </header>
            
            <!-- Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6 lg:p-8">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 shadow-sm">
                        <div class="w-8 h-8 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                
                <!-- Error Message -->
                @if(session('error'))
                    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl flex items-center gap-3 shadow-sm">
                        <div class="w-8 h-8 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                            </svg>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif
                
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
    </div>
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMobileMenu() {
            const mobileSidebar = document.getElementById('mobileSidebar');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const isOpen = !mobileSidebar.classList.contains('-translate-x-full');
            
            if (isOpen) {
                mobileSidebar.classList.add('-translate-x-full');
                mobileOverlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                mobileSidebar.classList.remove('-translate-x-full');
                mobileOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }
    </script>
    
    @livewireScripts
    @yield('scripts')
</body>
</html>
