@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="max-w-7xl mx-auto">
        <!-- Statistics Cards - Soft UI -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
            <!-- Jami Foydalanuvchilar -->
            <div
                class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wide">Jami
                            Foydalanuvchilar</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">{{ $totalUsers }}</p>
                        <div class="flex items-center gap-1 mt-2">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                +{{$thisMonthActiveUsersPercent}}% bu oy
                            </span>
                        </div>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Jami Testlar -->
            <div
                class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wide">Jami Testlar</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">{{ $totalTests }}</p>
                        <p class="text-xs text-slate-400 mt-2">Barcha vaqt davomida</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tugallangan -->
            <div
                class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wide">Tugallangan</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">{{ $completedTests }}</p>
                        <div class="flex items-center gap-1 mt-2">
                            <div class="w-full bg-slate-100 rounded-full h-1.5 max-w-[80px]">
                                <div class="bg-purple-500 h-1.5 rounded-full"
                                    style="width: {{ $totalTests > 0 ? round(($completedTests / $totalTests) * 100, 1) : 0 }}%">
                                </div>
                            </div>
                            <span
                                class="text-xs text-slate-500 font-medium">{{ $totalTests > 0 ? round(($completedTests / $totalTests) * 100, 1) : 0 }}%</span>
                        </div>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-200 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- O'rtacha Muvofiqlik -->
            <div
                class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 group">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-slate-500 uppercase tracking-wide">O'rtacha
                            Muvofiqlik</p>
                        <p class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">
                            {{ number_format($averageCompatibility, 1) }}%</p>
                        <p class="text-xs text-slate-400 mt-2">Barcha bo'limlar bo'yicha</p>
                    </div>
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg shadow-rose-200 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1: Daily Stats & Status Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <!-- Daily Test Trend (Line Chart) with Month Filter -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0H16.5m-13.5 0v11.25A2.25 2.25 0 006 16.5h2.25M12 7.5h3.75m-11.25 6H9m3 0h3m-3.75 3H15m-6 3h6m3.75-13.5V6m-9 9h.008v.008H12.75V15zm0 3h.008v.008H12.75V18z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">Kunlik Test Statistikasi</h3>
                    </div>
                    <select id="dailyFilter" onchange="updateDailyChart()"
                        class="text-sm bg-slate-50 border-0 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all cursor-pointer hover:bg-slate-100">
                        <option value="30days">Oxirgi 30 kun</option>
                        <option value="7days">Oxirgi 7 kun</option>
                        <option value="90days">Oxirgi 90 kun</option>
                        <option value="this_year">Bu yil</option>
                        <option value="month" data-month="{{ date('m') }}" data-year="{{ date('Y') }}">
                            {{ date('F Y') }}</option>
                    </select>
                </div>
                <div class="h-[280px] sm:h-[300px]">
                    <canvas id="dailyChart"></canvas>
                </div>
            </div>

            <!-- Test Status Distribution (Pie Chart) with Period Filter -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">Test Holati</h3>
                    </div>
                    <select id="statusFilter" onchange="updateStatusChart()"
                        class="text-sm bg-slate-50 border-0 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all cursor-pointer hover:bg-slate-100">
                        <option value="all">Barcha davr</option>
                        <option value="this_month">Bu oy</option>
                        <option value="this_year" selected>Bu yil</option>
                        <option value="last_year">O'tgan yil</option>
                    </select>
                </div>
                <div class="h-[240px] sm:h-[250px]">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Charts Row 2: Gender, Age & Compatibility -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <!-- Gender Distribution (Doughnut) -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-rose-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Jins Taqsimoti</h3>
                </div>
                <div class="h-[200px] sm:h-[220px]">
                    <canvas id="genderChart"></canvas>
                </div>
                <div class="mt-4 flex justify-center gap-6 text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-slate-600">Erkak: <span
                                class="font-semibold text-slate-900">{{ $genderDistribution['male'] ?? 0 }}</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                        <span class="text-slate-600">Ayol: <span
                                class="font-semibold text-slate-900">{{ $genderDistribution['female'] ?? 0 }}</span></span>
                    </div>
                </div>
            </div>

            <!-- Age Distribution (Bar Chart) -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Yosh Taqsimoti</h3>
                </div>
                <div class="h-[230px] sm:h-[250px]">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>

            <!-- Compatibility Ranges (Bar Chart) with Year Filter -->
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="flex flex-wrap justify-between items-center gap-3 mb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">Muvofiqlik</h3>
                    </div>
                    <select id="compatibilityFilter" onchange="updateCompatibilityChart()"
                        class="text-sm bg-slate-50 border-0 rounded-xl px-3 py-2 text-slate-700 focus:ring-2 focus:ring-amber-500 focus:bg-white transition-all cursor-pointer hover:bg-slate-100">
                        <option value="all">Barcha</option>
                        <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                        <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                    </select>
                </div>
                <div class="h-[230px] sm:h-[250px]">
                    <canvas id="compatibilityChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Charts Row 3: Unit Performance (Full Width) -->
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-8">
            <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">Bo'limlar Bo'yicha O'rtacha Muvofiqlik</h3>
                </div>
                <select id="unitFilter" onchange="updateUnitChart()"
                    class="text-sm bg-slate-50 border-0 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all cursor-pointer hover:bg-slate-100">
                    <option value="all">Barcha davr</option>
                    <option value="{{ date('Y') }}" selected>{{ date('Y') }} yil</option>
                    <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }} yil</option>
                </select>
            </div>
            <div class="h-[320px] sm:h-[350px]">
                <canvas id="unitChart"></canvas>
            </div>
        </div>

        <!-- Recent Test Sessions - Soft UI Table -->
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden mb-8">
            <div class="px-5 sm:px-6 py-5 border-b border-slate-100 flex flex-wrap justify-between items-center gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-cyan-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">So'nggi Test Sessiyalari</h3>
                        <p class="text-sm text-slate-500">Oxirgi 10 ta test natijasi</p>
                    </div>
                </div>
                <a href="{{ route('admin.test-sessions.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 rounded-xl text-sm font-medium transition-all duration-200">
                    Barchasini ko'rish
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                    </svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th
                                class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                ID</th>
                            <th
                                class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Boshlovchi</th>
                            <th
                                class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Sherik</th>
                            <th
                                class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Holati</th>
                            <th
                                class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Yaratilgan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($recentSessions as $session)
                            <tr class="hover:bg-slate-50/60 transition-colors duration-200">
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-sm font-mono font-medium">#{{ $session->id }}</span>
                                </td>
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($session->initiator->jshshir, 0, 1) }}
                                        </div>
                                        <span
                                            class="text-sm font-medium text-slate-700 font-mono">{{ $session->initiator->jshshir }}</span>
                                    </div>
                                </td>
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-rose-400 to-rose-500 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($session->partner->jshshir, 0, 1) }}
                                        </div>
                                        <span
                                            class="text-sm font-medium text-slate-700 font-mono">{{ $session->partner->jshshir }}</span>
                                    </div>
                                </td>
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                    @if ($session->status === 'completed')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                            Tugallangan
                                        </span>
                                    @elseif($session->status === 'in_progress')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                            Jarayonda
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                            Kutilmoqda
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $session->created_at->format('d.m.Y') }}
                                    <span class="text-slate-400 ml-1">{{ $session->created_at->format('H:i') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly Stats Chart -->
        @if ($monthlyStats->count() > 0)
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="flex flex-wrap justify-between items-center gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900">Oylik Statistika</h3>
                    </div>
                    <select id="monthlyFilter" onchange="updateMonthlyChart()"
                        class="text-sm bg-slate-50 border-0 rounded-xl px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all cursor-pointer hover:bg-slate-100">
                        <option value="6months" selected>Oxirgi 6 oy</option>
                        <option value="12months">Oxirgi 12 oy</option>
                        <option value="this_year">Bu yil</option>
                        <option value="last_year">O'tgan yil</option>
                    </select>
                </div>
                <div class="h-[230px] sm:h-[250px]">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        @endif
    </div>

    <!-- Chart.js Scripts -->
    <script>
        // Common chart options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 11
                        }
                    }
                }
            }
        };

        // 1. Daily Stats Line Chart
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($dailyStats->pluck('date')->map(fn($d) => date('d.m', strtotime($d)))) !!},
                datasets: [{
                    label: 'Jami testlar',
                    data: {!! json_encode($dailyStats->pluck('total')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Tugallangan',
                    data: {!! json_encode($dailyStats->pluck('completed')) !!},
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Jarayonda',
                    data: {!! json_encode($dailyStats->pluck('in_progress') ?? collect()) !!},
                    borderColor: 'rgb(245, 158, 11)',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Kutilmoqda',
                    data: {!! json_encode($dailyStats->pluck('waiting') ?? collect()) !!},
                    borderColor: 'rgb(107, 114, 128)',
                    backgroundColor: 'rgba(107, 114, 128, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                ...commonOptions,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // 2. Test Status Pie Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Tugallangan', 'Jarayonda', 'Kutilmoqda'],
                datasets: [{
                    data: [
                        {{ $testStatusDistribution['completed'] ?? 0 }},
                        {{ $testStatusDistribution['in_progress'] ?? 0 }},
                        {{ $testStatusDistribution['waiting'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(107, 114, 128)'
                    ],
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });

        // 3. Gender Doughnut Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Erkak', 'Ayol'],
                datasets: [{
                    data: [{{ $genderDistribution['male'] ?? 0 }},
                        {{ $genderDistribution['female'] ?? 0 }}
                    ],
                    backgroundColor: ['rgb(59, 130, 246)', 'rgb(236, 72, 153)'],
                    borderWidth: 0
                }]
            },
            options: commonOptions
        });

        // 4. Age Distribution Bar Chart
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($ageGroups)) !!},
                datasets: [{
                    label: 'Foydalanuvchilar',
                    data: {!! json_encode(array_values($ageGroups)) !!},
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(139, 92, 246)',
                        'rgb(239, 68, 68)'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // 5. Compatibility Ranges Bar Chart
        const compatCtx = document.getElementById('compatibilityChart').getContext('2d');
        new Chart(compatCtx, {
            type: 'bar',
            data: {
                labels: ['A\'lo (80%+)', 'Yaxshi (60-79%)', 'O\'rta (40-59%)', 'Past (<40%)'],
                datasets: [{
                    label: 'Juftliklar soni',
                    data: [
                        {{ $compatibilityRanges['excellent'] }},
                        {{ $compatibilityRanges['good'] }},
                        {{ $compatibilityRanges['average'] }},
                        {{ $compatibilityRanges['poor'] }}
                    ],
                    backgroundColor: [
                        'rgb(16, 185, 129)',
                        'rgb(59, 130, 246)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // 6. Unit Performance Horizontal Bar Chart
        const unitCtx = document.getElementById('unitChart').getContext('2d');
        new Chart(unitCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($unitPerformance->pluck('name')) !!},
                datasets: [{
                    label: "O'rtacha muvofiqlik (%)",
                    data: {!! json_encode($unitPerformance->pluck('avg_score')) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderColor: 'rgb(99, 102, 241)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // 7. Monthly Stats Chart
        @if ($monthlyStats->count() > 0) const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyStats->pluck('month')) !!},
            datasets: [{
                label: 'Jami testlar',
                data: {!! json_encode($monthlyStats->pluck('total')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderRadius: 4
            }, {
                label: 'Tugallangan',
                data: {!! json_encode($monthlyStats->pluck('completed')) !!},
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderRadius: 4
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    }); @endif

        // Chart instances storage
        let dailyChartInstance, statusChartInstance, compatibilityChartInstance, unitChartInstance, monthlyChartInstance;

        // Store chart instances when creating
        document.addEventListener('DOMContentLoaded', function() {
            // Store references to chart instances
            dailyChartInstance = Chart.getChart('dailyChart');
            statusChartInstance = Chart.getChart('statusChart');
            compatibilityChartInstance = Chart.getChart('compatibilityChart');
            unitChartInstance = Chart.getChart('unitChart');
            monthlyChartInstance = Chart.getChart('monthlyChart');
        });

        // Update Daily Chart
        function updateDailyChart() {
            const filter = document.getElementById('dailyFilter').value;
            const url = new URL('{{ route('admin.dashboard.chart-data') }}', window.location.origin);
            url.searchParams.append('chart', 'daily');
            url.searchParams.append('period', filter);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chart = Chart.getChart('dailyChart');
                    if (chart) {
                        chart.data.labels = data.labels;
                        chart.data.datasets[0].data = data.total;
                        chart.data.datasets[1].data = data.completed;
                        chart.data.datasets[2].data = data.in_progress;
                        chart.data.datasets[3].data = data.waiting;
                        chart.update();
                    }
                })
                .catch(error => console.error('Error updating daily chart:', error));
        }

        // Update Status Chart
        function updateStatusChart() {
            const filter = document.getElementById('statusFilter').value;
            const url = new URL('{{ route('admin.dashboard.chart-data') }}', window.location.origin);
            url.searchParams.append('chart', 'status');
            url.searchParams.append('period', filter);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chart = Chart.getChart('statusChart');
                    if (chart) {
                        chart.data.datasets[0].data = [data.completed, data.in_progress, data.waiting];
                        chart.update();
                    }
                })
                .catch(error => console.error('Error updating status chart:', error));
        }

        // Update Compatibility Chart
        function updateCompatibilityChart() {
            const year = document.getElementById('compatibilityFilter').value;
            const url = new URL('{{ route('admin.dashboard.chart-data') }}', window.location.origin);
            url.searchParams.append('chart', 'compatibility');
            url.searchParams.append('year', year);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chart = Chart.getChart('compatibilityChart');
                    if (chart) {
                        chart.data.datasets[0].data = [data.excellent, data.good, data.average, data.poor];
                        chart.update();
                    }
                })
                .catch(error => console.error('Error updating compatibility chart:', error));
        }

        // Update Unit Chart
        function updateUnitChart() {
            const year = document.getElementById('unitFilter').value;
            const url = new URL('{{ route('admin.dashboard.chart-data') }}', window.location.origin);
            url.searchParams.append('chart', 'units');
            url.searchParams.append('year', year);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chart = Chart.getChart('unitChart');
                    if (chart) {
                        chart.data.labels = data.labels;
                        chart.data.datasets[0].data = data.scores;
                        chart.update();
                    }
                })
                .catch(error => console.error('Error updating unit chart:', error));
        }

        // Update Monthly Chart
        function updateMonthlyChart() {
            const filter = document.getElementById('monthlyFilter')?.value || '6months';
            const url = new URL('{{ route('admin.dashboard.chart-data') }}', window.location.origin);
            url.searchParams.append('chart', 'monthly');
            url.searchParams.append('period', filter);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const chart = Chart.getChart('monthlyChart');
                    if (chart) {
                        chart.data.labels = data.labels;
                        chart.data.datasets[0].data = data.total;
                        chart.data.datasets[1].data = data.completed;
                        chart.update();
                    }
                })
                .catch(error => console.error('Error updating monthly chart:', error));
        }
    </script>
@endsection
