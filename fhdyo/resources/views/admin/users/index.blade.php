@extends('layouts.admin')

@section('title', 'Foydalanuvchilar')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="flex flex-wrap justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Foydalanuvchilar</h2>
            <p class="text-slate-500 mt-1">Tizimdagi barcha foydalanuvchilar ro'yxati</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 rounded-xl">
                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                <span class="text-sm text-slate-600">Erkak: <strong class="text-slate-900">{{ $totalGenderCounts['male'] ?? 0 }}</strong></span>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-rose-50 rounded-xl">
                <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                <span class="text-sm text-slate-600">Ayol: <strong class="text-slate-900">{{ $totalGenderCounts['female'] ?? 0 }}</strong></span>
            </div>
        </div>
    </div>

    <!-- Search and Filter - Soft UI -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4 items-end">
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
                <label class="block text-sm font-medium text-slate-700 mb-2">Jinsi</label>
                <select
                    name="gender"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[140px]"
                >
                    <option value="">Barchasi</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Erkak</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Ayol</option>
                </select>
            </div>
            <button
                type="submit"
                class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-medium transition-all duration-200"
            >
                Qidirish
            </button>
            @if(request()->has('search') || request()->has('gender'))
                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200"
                >
                    Tozalash
                </a>
            @endif
        </form>
    </div>

    <!-- Users Table - Soft UI -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">JSHSHIR</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tug'ilgan</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Yosh</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Jinsi</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Testlar</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/60 transition-colors duration-200">
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-sm font-mono font-medium">#{{ $user->id }}</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 {{ $user->gender === 'male' ? 'bg-gradient-to-br from-blue-400 to-blue-500' : 'bg-gradient-to-br from-rose-400 to-rose-500' }} rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($user->jshshir, 0, 1) }}
                                    </div>
                                    <span class="text-sm font-medium text-slate-700 font-mono">{{ $user->jshshir }}</span>
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $user->birth_date ? $user->birth_date->format('d.m.Y') : '-' }}
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-slate-700">{{ $user->age ?? '-' }} yosh</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $user->gender === 'male' ? 'bg-blue-50 text-blue-700' : 'bg-rose-50 text-rose-700' }}">
                                    {{ $user->gender === 'male' ? 'Erkak' : 'Ayol' }}
                                </span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full {{ ($user->initiatorSessions->count() + $user->partnerSessions->count()) > 0 ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                                    <span class="text-sm font-medium text-slate-700">{{ $user->initiatorSessions->count() + $user->partnerSessions->count() }}</span>
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200" title="Tahrirlash">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Foydalanuvchini o\'chirishni hohlaysizmi?');">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Foydalanuvchilar topilmadi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination - Soft UI -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
