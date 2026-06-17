<!DOCTYPE html>
<html lang="uz" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nikoh Testi') - Nikoh Testi</title>
     
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-slate-50 text-slate-900 font-sans antialiased">
    <div class="min-h-full flex flex-col">
        <!-- Navigation - Soft UI -->
        <nav class="bg-white border-b border-slate-200 shadow-sm">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-slate-900">Nikoh Testi</h1>
                    </div>
                    <div class="flex items-center gap-2">
                        @if(request()->is('admin*'))
                            <a href="{{ route('admin.dashboard') }}" class="text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 px-3 py-2 rounded text-sm font-medium transition-colors">
                                Admin
                            </a>
                        @else
                            <a href="{{ route('user.entry') }}" class="text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 px-3 py-2 rounded text-sm font-medium transition-colors">
                                Foydalanuvchi
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 w-full">
            @if(isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>

        <!-- Footer - Soft UI -->
        <footer class="bg-white border-t border-slate-200 py-2">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="text-center flex items-center justify-between md:flex gap-2">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <div class="w-6 h-6 bg-indigo-100 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <span class="text-slate-900 font-semibold">Nikoh Testi</span>
                    </div>
                    <p class="text-sm text-slate-500">
                        &copy; {{ date('Y') }} Nikoh Testi. Barcha huquqlar himoyalangan.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Flash Messages - Soft UI -->
    @if(session()->has('success'))
        <div class="fixed top-4 right-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded shadow-lg z-50 flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="fixed top-4 right-4 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded shadow-lg z-50 flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('info'))
        <div class="fixed top-4 right-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded shadow-lg z-50 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('info') }}
        </div>
    @endif

    @livewireScripts
    @yield('scripts')
</body>
</html>
