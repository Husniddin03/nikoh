@extends('layouts.admin')

@section('title', 'Bo\'limlar')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="flex flex-wrap justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Bo'limlar</h2>
            <p class="text-slate-500 mt-1">Test bo'limlarini boshqarish va nazorat qilish</p>
        </div>
        <a href="{{ route('admin.units.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"></path>
            </svg>
            Yangi Bo'lim
        </a>
    </div>

    <!-- Search and Filter - Soft UI -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6">
        <form method="GET" action="{{ route('admin.units.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-slate-700 mb-2">Qidirish</label>
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
                        placeholder="Bo'lim nomi..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    >
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Kategoriya</label>
                <select
                    name="category"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[140px]"
                >
                    <option value="">Barchasi</option>
                    <option value="nikoh" {{ request('category') === 'nikoh' ? 'selected' : '' }}>Nikoh</option>
                    <option value="ajrim" {{ request('category') === 'ajrim' ? 'selected' : '' }}>Ajrim</option>
                </select>
            </div>
            <button
                type="submit"
                class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-medium transition-all duration-200"
            >
                Qidirish
            </button>
            @if(request()->filled('search') || request()->filled('category'))
                <a href="{{ route('admin.units.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
                    Tozalash
                </a>
            @endif
        </form>
    </div>

    <!-- Units Table - Soft UI -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Nomi
                        </th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Kategoriya
                        </th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Savollar
                        </th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Yaratilgan
                        </th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            Amallar
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($units as $unit)
                        <tr class="hover:bg-slate-50/60 transition-colors duration-200">
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-sm font-mono font-medium">
                                    #{{ $unit->id }}
                                </span>
                            </td>
                            <td class="px-5 sm:px-6 py-4">
                                <div>
                                    <div class="font-semibold text-slate-900">{{ $unit->name }}</div>
                                    @if($unit->description)
                                        <div class="text-xs text-slate-500 mt-1 line-clamp-1">{{ Str::limit($unit->description, 60) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $unit->category === 'nikoh' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $unit->category === 'nikoh' ? 'Nikoh' : 'Ajrim' }}
                                </span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ $unit->questions_count > 0 ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                    <span class="text-sm font-medium text-slate-700">{{ $unit->questions_count }}</span>
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $unit->created_at->format('d.m.Y') }}
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.units.show', $unit) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all duration-200" title="Ko'rish">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.units.edit', $unit) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200" title="Tahrirlash">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.units.destroy', $unit) }}" method="POST" class="inline" onsubmit="return confirm('Bo\'limni o\'chirishni hohlaysizmi?');">
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
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Bo'limlar topilmadi</p>
                                <p class="text-sm text-slate-400 mt-1">Yangi bo'lim qo'shish uchun yuqoridagi tugmani bosing</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination - Soft UI -->
    @if($units->hasPages())
        <div class="mt-6">
            {{ $units->links() }}
        </div>
    @endif
</div>
@endsection
