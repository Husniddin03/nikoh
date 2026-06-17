@extends('layouts.app')

@section('title', 'Natijalar')

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-6xl mx-auto">
        <!-- Overall Compatibility Score - Soft UI -->
        <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.08)] text-center mb-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Umumiy Muvofiqlik</h2>
            <div class="text-5xl sm:text-6xl font-bold text-emerald-500 mb-3">
                {{ $overallCompatibility !== null ? number_format($overallCompatibility, 1) : '0.0' }}%
            </div>
            <p class="text-slate-600">
                @if($overallCompatibility === null)
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 animate-spin text-emerald-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Natijalar hisoblanmoqda...
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded {{ $overallCompatibility >= 75 ? 'bg-emerald-100 text-emerald-700' : ($overallCompatibility >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                        @if($overallCompatibility >= 75)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($overallCompatibility >= 50)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                        {{ $overallCompatibility >= 75 ? 'Yuqori muvofiqlik' : ($overallCompatibility >= 50 ? 'O\'rtacha muvofiqlik' : 'Past muvofiqlik') }}
                    </span>
                @endif
            </p>
        </div>

        <!-- Chart Section - Soft UI -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Bo'limlar bo'yicha Muvofiqlik
            </h3>
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-5">
                @forelse(collect($chartData['datasets'][0]['data'] ?? []) as $index => $percentage)
                    <div class="mb-3 last:mb-0">
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-sm font-medium text-slate-700">{{ $chartData['labels'][$index] }}</span>
                            <span class="text-sm font-semibold {{ $percentage >= 75 ? 'text-emerald-600' : ($percentage >= 50 ? 'text-amber-600' : 'text-rose-600') }}">{{ number_format($percentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
                            <div
                                class="h-full transition-all duration-500 rounded-full {{ $percentage >= 75 ? 'bg-emerald-500' : ($percentage >= 50 ? 'bg-amber-400' : 'bg-rose-400') }}"
                                style="width: {{ min(100, $percentage) }}%"
                            ></div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-slate-500">Natijalar topilmadi</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Unit Scores Table - Soft UI -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Batafsil Natijalar
            </h3>
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Bo'lim
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Kategoriya
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Foiz
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">
                                Sharh
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($unitScores as $score)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 text-sm text-slate-900 font-medium">
                                    {{ $score->unit->name }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full {{ $score->unit->category === 'nikoh' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $score->unit->category === 'nikoh' ? 'Nikoh' : 'Ajrim' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5 text-sm font-semibold {{ $score->match_percentage >= 75 ? 'text-emerald-600' : ($score->match_percentage >= 50 ? 'text-amber-600' : 'text-rose-600') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($score->match_percentage >= 75)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @elseif($score->match_percentage >= 50)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            @endif
                                        </svg>
                                        {{ number_format($score->match_percentage, 1) }}%
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-600">
                                    {{ $score->interpretation }}
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center">
                                <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-slate-500">Bo'limlar bo'yicha natijalar mavjud emas</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recommendations - Soft UI -->
        @if(count($recommendations) > 0)
            <div class="mb-8">
                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                    </svg>
                    Tavsiyalar
                </h3>
                <div class="space-y-3">
                    @foreach($recommendations as $recommendation)
                        <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-amber-100 rounded-xl flex items-center justify-center">
                                    <svg class="h-4 w-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-slate-900">
                                        {{ $recommendation['unit_name'] }} ({{ number_format($recommendation['score'], 1) }}%)
                                    </h4>
                                    <p class="mt-1 text-sm text-slate-600">
                                        {{ $recommendation['recommendation'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Detailed Answers Comparison - Soft UI -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Batafsil Javoblar Taqqoslash
            </h3>
            
            <!-- Stats Summary - Soft UI -->
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="bg-emerald-50 rounded-xl p-4 text-center border border-emerald-200">
                    <div class="text-2xl font-bold text-emerald-600">
                        {{ count(array_filter($answersComparison, fn($a) => $a['is_match'])) }}
                    </div>
                    <div class="text-sm text-emerald-700 font-medium">Mos kelgan</div>
                </div>
                <div class="bg-rose-50 rounded-xl p-4 text-center border border-rose-200">
                    <div class="text-2xl font-bold text-rose-600">
                        {{ count(array_filter($answersComparison, fn($a) => !$a['is_match'])) }}
                    </div>
                    <div class="text-sm text-rose-700 font-medium">Zid kelgan</div>
                </div>
                <div class="bg-amber-50 rounded-xl p-4 text-center border border-amber-200">
                    <div class="text-2xl font-bold text-amber-600">
                        {{ count(array_filter($answersComparison, fn($a) => $a['is_critical'] && !$a['is_match'])) }}
                    </div>
                    <div class="text-sm text-amber-700 font-medium">Muhim zid</div>
                </div>
            </div>
            
            <!-- Filters - Soft UI -->
            <div class="flex flex-wrap gap-2 mb-4">
                <button onclick="filterAnswers('all')" class="px-3 py-2 bg-emerald-500 text-white text-sm font-medium rounded-xl hover:bg-emerald-600 transition-colors" id="filter-all">
                    Barchasi ({{ count($answersComparison) }})
                </button>
                <button onclick="filterAnswers('match')" class="px-3 py-2 bg-white text-slate-700 text-sm font-medium rounded-xl border border-slate-200 hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-200 transition-colors" id="filter-match">
                    Mos kelgan
                </button>
                <button onclick="filterAnswers('mismatch')" class="px-3 py-2 bg-white text-slate-700 text-sm font-medium rounded-xl border border-slate-200 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-colors" id="filter-mismatch">
                    Zid kelgan
                </button>
                <button onclick="filterAnswers('critical')" class="px-3 py-2 bg-white text-slate-700 text-sm font-medium rounded-xl border border-slate-200 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-200 transition-colors" id="filter-critical">
                    Muhim savollar
                </button>
            </div>
            
            <!-- Answers Table - Soft UI -->
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden max-h-96 overflow-y-auto">
                <table class="w-full" id="answers-table">
                    <thead class="bg-slate-50 border-b border-slate-200 sticky top-0">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-700 uppercase w-8">#</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-700 uppercase">Savol</th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-700 uppercase w-24">Bo'lim</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-slate-700 uppercase w-16">Muhim</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-slate-700 uppercase w-12">Siz</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-slate-700 uppercase w-12">Sherik</th>
                            <th class="px-3 py-3 text-center text-xs font-semibold text-slate-700 uppercase w-20">Natija</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($answersComparison as $index => $answer)
                            <tr class="answer-row {{ $answer['is_match'] ? 'match' : 'mismatch' }} {{ $answer['is_critical'] ? 'critical' : '' }} hover:bg-slate-50 transition-colors"
                                data-match="{{ $answer['is_match'] ? '1' : '0' }}"
                                data-critical="{{ $answer['is_critical'] ? '1' : '0' }}">
                                <td class="px-3 py-3 text-sm text-slate-500">{{ $index + 1 }}</td>
                                <td class="px-3 py-3 text-sm text-slate-900">{{ $answer['question'] }}</td>
                                <td class="px-3 py-3 text-sm text-slate-600">{{ $answer['unit_name'] }}</td>
                                <td class="px-3 py-3 text-center">
                                    @if($answer['is_critical'])
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-bold text-rose-700 bg-rose-100 rounded-full">MUHIM</span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-center">
                                    @if($answer['user_answer'])
                                        <span class="inline-flex items-center justify-center w-8 h-6 text-xs font-bold text-white bg-emerald-500 rounded-lg">HA</span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-8 h-6 text-xs font-bold text-white bg-rose-500 rounded-lg">YO'Q</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-center">
                                    @if($answer['partner_answer'])
                                        <span class="inline-flex items-center justify-center w-8 h-6 text-xs font-bold text-white bg-emerald-500 rounded-lg">HA</span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-8 h-6 text-xs font-bold text-white bg-rose-500 rounded-lg">YO'Q</span>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-center">
                                    @if($answer['is_match'])
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold text-emerald-700 bg-emerald-100 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Mos
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold text-rose-700 bg-rose-100 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Zid
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center">
                                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                    <p class="text-slate-500">Javoblar mavjud emas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Partner Info - Soft UI -->
        <div class="text-center mb-8">
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-4 inline-flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                    </svg>
                </div>
                <div class="text-left">
                    <h3 class="text-sm font-semibold text-slate-900">Test Sherigi</h3>
                    <p class="text-sm text-slate-600">JSHSHIR: {{ $partner->jshshir }} · Jinsi: {{ $partner->gender === 'male' ? 'Erkak' : 'Ayol' }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons - Soft UI -->
        <div class="text-center space-y-3">
            <div class="flex flex-col sm:flex-row justify-center gap-3">
                <a href="{{ route('user.results.pdf', $session->id) }}" class="inline-flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white py-2.5 px-5 rounded-xl font-medium text-sm transition-all shadow-lg shadow-emerald-200 hover:shadow-xl hover:shadow-emerald-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    PDF Yuklab Olish
                </a>
                <a href="{{ route('user.entry') }}" class="inline-flex items-center justify-center gap-2 bg-white text-emerald-600 hover:bg-emerald-50 py-2.5 px-5 rounded-xl font-medium text-sm border-2 border-emerald-200 hover:border-emerald-300 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    Yangi Test Boshlash
                </a>
            </div>
            <p class="text-xs text-slate-500">
                PDF hujjatni yuklab olib, elektron yoki chop etilgan shaklda saqlashingiz mumkin
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars on page load
    const progressBars = document.querySelectorAll('.bg-green-600, .bg-yellow-500, .bg-red-600');
    
    setTimeout(() => {
        progressBars.forEach((bar, index) => {
            setTimeout(() => {
                bar.style.transition = 'width 1s ease-out';
            }, index * 100);
        });
    }, 100);
});

// Filter answers table - Soft UI
function filterAnswers(filter) {
    const rows = document.querySelectorAll('.answer-row');
    const buttons = ['filter-all', 'filter-match', 'filter-mismatch', 'filter-critical'];
    
    // Update button styles
    buttons.forEach(btnId => {
        const btn = document.getElementById(btnId);
        if (btnId === 'filter-' + filter) {
            // Active state
            btn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
            btn.classList.add('bg-emerald-500', 'text-white', 'border-emerald-500');
            // Remove hover classes for active
            if (btnId === 'filter-match') {
                btn.classList.remove('hover:bg-emerald-50', 'hover:text-emerald-700', 'hover:border-emerald-200');
            } else if (btnId === 'filter-mismatch') {
                btn.classList.remove('hover:bg-rose-50', 'hover:text-rose-700', 'hover:border-rose-200');
            } else if (btnId === 'filter-critical') {
                btn.classList.remove('hover:bg-amber-50', 'hover:text-amber-700', 'hover:border-amber-200');
            }
        } else {
            // Inactive state
            btn.classList.remove('bg-emerald-500', 'text-white', 'border-emerald-500');
            btn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
            // Add hover classes
            if (btnId === 'filter-match') {
                btn.classList.add('hover:bg-emerald-50', 'hover:text-emerald-700', 'hover:border-emerald-200');
            } else if (btnId === 'filter-mismatch') {
                btn.classList.add('hover:bg-rose-50', 'hover:text-rose-700', 'hover:border-rose-200');
            } else if (btnId === 'filter-critical') {
                btn.classList.add('hover:bg-amber-50', 'hover:text-amber-700', 'hover:border-amber-200');
            }
        }
    });
    
    // Filter rows
    rows.forEach(row => {
        const isMatch = row.getAttribute('data-match') === '1';
        const isCritical = row.getAttribute('data-critical') === '1';
        
        let show = false;
        switch(filter) {
            case 'all':
                show = true;
                break;
            case 'match':
                show = isMatch;
                break;
            case 'mismatch':
                show = !isMatch;
                break;
            case 'critical':
                show = isCritical && !isMatch;
                break;
        }
        
        row.style.display = show ? '' : 'none';
    });
}
</script>
@endsection
