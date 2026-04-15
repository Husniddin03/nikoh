@extends('layouts.admin')

@section('title', 'Juftliklar')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="flex flex-wrap justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Juftliklar</h2>
            <p class="text-slate-500 mt-1">Test sessiyalari va juftliklarni boshqarish</p>
        </div>
        <a href="{{ route('admin.test-sessions.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"></path>
            </svg>
            Yangi Juftlik
        </a>
    </div>

    <!-- Status Legend - Soft UI -->
    <div class="flex flex-wrap items-center gap-4 sm:gap-6 mb-6 p-4 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        <span class="text-sm font-medium text-slate-600">Holatlar:</span>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
            <span class="text-sm text-slate-600">Testni tugatgan</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
            <span class="text-sm text-slate-600">Testni tugatmagan</span>
        </div>
        <div class="flex items-center gap-2 ml-auto">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-medium">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                Tugallangan ({{ $statusCounts['completed'] ?? 0 }})
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 rounded-full text-xs font-medium">
                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                Jarayonda ({{ $statusCounts['in_progress'] ?? 0 }})
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                Kutilmoqda ({{ $statusCounts['waiting'] ?? 0 }})
            </span>
        </div>
    </div>

    <!-- Search and Filter - Soft UI -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6">
        <form method="GET" action="{{ route('admin.test-sessions.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-slate-700 mb-2">JSHSHIR bo'yicha qidirish</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="JSHSHIR kiriting..."
                        maxlength="14"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-mono"
                    >
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Holati</label>
                <select
                    name="status"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[140px]"
                >
                    <option value="">Barchasi</option>
                    <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Kutilmoqda</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Jarayonda</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Tugallangan</option>
                </select>
            </div>
            <button
                type="submit"
                class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-medium transition-all duration-200"
            >
                Qidirish
            </button>
            @if(request()->has('search') || request()->has('status'))
                <a
                    href="{{ route('admin.test-sessions.index') }}"
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200"
                >
                    Tozalash
                </a>
            @endif
        </form>
    </div>

    <!-- Test Sessions Table - Soft UI -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Boshlovchi</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Sherik</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Holati</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Javoblar</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Yaratilgan</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $session)
                        <tr class="hover:bg-slate-50/60 transition-colors duration-200">
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-sm font-mono font-medium">#{{ $session->id }}</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 {{ $session->initiator->gender === 'male' ? 'bg-gradient-to-br from-blue-400 to-blue-500' : 'bg-gradient-to-br from-rose-400 to-rose-500' }} rounded-xl flex items-center justify-center text-white text-sm font-bold">
                                            {{ substr($session->initiator->jshshir, 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-mono text-sm font-medium text-slate-700">{{ $session->initiator->jshshir }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ $session->initiator->gender === 'male' ? 'Erkak' : 'Ayol' }}, {{ $session->initiator->age ?? '?' }} yosh
                                        </p>
                                    </div>
                                    @if($session->isInitiatorCompleted())
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0" title="Testni tugatgan"></span>
                                    @else
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 flex-shrink-0" title="Testni tugatmagan"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 {{ $session->partner->gender === 'male' ? 'bg-gradient-to-br from-blue-400 to-blue-500' : 'bg-gradient-to-br from-rose-400 to-rose-500' }} rounded-xl flex items-center justify-center text-white text-sm font-bold">
                                            {{ substr($session->partner->jshshir, 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <p class="font-mono text-sm font-medium text-slate-700">{{ $session->partner->jshshir }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ $session->partner->gender === 'male' ? 'Erkak' : 'Ayol' }}, {{ $session->partner->age ?? '?' }} yosh
                                        </p>
                                    </div>
                                    @if($session->isPartnerCompleted())
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0" title="Testni tugatgan"></span>
                                    @else
                                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500 flex-shrink-0" title="Testni tugatmagan"></span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                @if($session->status === 'completed')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                        Tugallangan
                                    </span>
                                @elseif($session->status === 'in_progress')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                        Jarayonda
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                        Kutilmoqda
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $session->results->count() > 0 ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                    <span class="text-sm font-medium text-slate-700">{{ $session->results->count() }}</span>
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $session->created_at->format('d.m.Y') }}
                                <span class="text-slate-400 ml-1">{{ $session->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.test-sessions.show', $session) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all duration-200" title="Ko'rish">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.test-sessions.destroy', $session) }}" method="POST" class="inline" onsubmit="return confirm('Juftlikni o\'chirishni hohlaysizmi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all duration-200" title="O'chirish">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Juftliklar topilmadi</p>
                                <p class="text-sm text-slate-400 mt-1">Yangi juftlik qo'shish uchun yuqoridagi tugmani bosing</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination - Soft UI -->
    <div class="mt-6">
        {{ $sessions->links() }}
    </div>
</div>
@endsection
