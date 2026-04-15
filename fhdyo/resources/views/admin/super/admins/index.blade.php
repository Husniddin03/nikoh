@extends('layouts.admin')

@section('title', 'Adminlar Boshqaruvi')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="flex flex-wrap justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Adminlar Boshqaruvi</h2>
            <p class="text-slate-500 mt-1">Tizim administratorlarini boshqarish</p>
        </div>
        <a href="{{ route('admin.super.admins.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"></path>
            </svg>
            Yangi Admin
        </a>
    </div>

    <!-- Current Admin Info - Soft UI -->
    <div class="mb-6 p-4 bg-amber-50 rounded-xl border border-amber-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm text-amber-900">
                    <span class="font-semibold">Joriy admin:</span> 
                    <span class="font-medium">{{ auth('admin')->user()->name }}</span>
                    <span class="text-amber-700">({{ auth('admin')->user()->username }})</span>
                    @if(auth('admin')->user()->is_super_admin)
                        <span class="ml-2 inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold text-rose-700 bg-rose-100 rounded-full">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            SUPER ADMIN
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter - Soft UI -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6">
        <form method="GET" action="{{ route('admin.super.admins.index') }}" class="flex flex-wrap gap-4 items-end">
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
                        placeholder="Ism yoki username..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all"
                    >
                </div>
            </div>
            <div class="min-w-[180px]">
                <label class="block text-sm font-medium text-slate-700 mb-2">Rol</label>
                <div class="relative">
                    <select
                        name="role"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all appearance-none cursor-pointer"
                    >
                        <option value="">Barchasi</option>
                        <option value="super" {{ request('role') === 'super' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <button
                type="submit"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Qidirish
            </button>
            @if(request()->filled('search') || request()->filled('role'))
                <a href="{{ route('admin.super.admins.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
                    Tozalash
                </a>
            @endif
        </form>
    </div>

    <!-- Admins Table - Soft UI -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Ism</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Username</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Yaratilgan</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-slate-50/60 transition-colors duration-200 {{ $admin->id === auth('admin')->id() ? 'bg-indigo-50/50' : '' }}">
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-sm font-mono font-medium">#{{ $admin->id }}</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 {{ $admin->is_super_admin ? 'bg-gradient-to-br from-rose-400 to-rose-500' : 'bg-gradient-to-br from-slate-400 to-slate-500' }} rounded-xl flex items-center justify-center text-white text-sm font-bold">
                                        {{ substr($admin->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="text-sm font-medium text-slate-900">{{ $admin->name }}</span>
                                        @if($admin->id === auth('admin')->id())
                                            <span class="block text-xs text-indigo-600 font-medium">Siz</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-slate-700 bg-slate-50 px-2.5 py-1 rounded-lg">{{ $admin->username }}</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                @if($admin->is_super_admin)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 rounded-full">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        SUPER ADMIN
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 rounded-full">
                                        Admin
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $admin->created_at->format('d.m.Y') }}
                                <span class="text-slate-300 ml-1">{{ $admin->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.super.admins.edit', $admin) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200" title="Tahrirlash">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                        </svg>
                                    </a>
                                    @if($admin->id !== auth('admin')->id())
                                        <form action="{{ route('admin.super.admins.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Adminni o\'chirishni hohlaysizmi?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all duration-200" title="O'chirish">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 002.25 6v11.25A2.25 2.25 0 004.5 19.5z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Adminlar topilmadi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $admins->links() }}
    </div>
</div>
@endsection
