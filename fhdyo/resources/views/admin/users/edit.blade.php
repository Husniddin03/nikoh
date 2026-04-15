@extends('layouts.admin')

@section('title', 'Foydalanuvchini Tahrirlash')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
            </svg>
            Foydalanuvchilarga qaytish
        </a>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Foydalanuvchini Tahrirlash</h2>
        <p class="text-slate-500 mt-1">Foydalanuvchi ma'lumotlarini yangilang</p>
    </div>

    <!-- Form - Soft UI -->
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        @csrf
        @method('PUT')

        <!-- JSHSHIR Field -->
        <div class="mb-6">
            <label for="jshshir" class="block text-sm font-medium text-slate-700 mb-2">
                JSHSHIR <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 002.25 6v11.25A2.25 2.25 0 004.5 19.5z"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    id="jshshir"
                    name="jshshir"
                    value="{{ old('jshshir', $user->jshshir) }}"
                    maxlength="14"
                    class="w-full pl-10 pr-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-mono"
                    required
                >
            </div>
            @error('jshshir')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Birth Date (Read-only from JSHSHIR) -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Tug'ilgan sana (JSHSHIR dan)
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"></path>
                    </svg>
                </div>
                <input
                    type="text"
                    value="{{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Aniqlanmadi' }}"
                    class="w-full pl-10 pr-4 py-3 bg-slate-100 border-0 rounded-xl text-slate-600 cursor-not-allowed"
                    readonly
                >
            </div>
            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                </svg>
                Tug'ilgan sana JSHSHIR dan avtomatik ajratiladi
            </p>
        </div>

        <!-- Gender Field -->
        <div class="mb-6">
            <label for="gender" class="block text-sm font-medium text-slate-700 mb-2">
                Jinsi <span class="text-rose-500">*</span>
            </label>
            <select
                id="gender"
                name="gender"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all"
                required
            >
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Erkak</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Ayol</option>
            </select>
            @error('gender')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Current Info - Soft UI -->
        <div class="mb-8 p-5 bg-slate-50 rounded-xl border border-slate-100">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 bg-slate-200 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 002.25 6v11.25A2.25 2.25 0 004.5 19.5z"></path>
                    </svg>
                </div>
                <h4 class="text-sm font-semibold text-slate-900">Joriy ma'lumotlar</h4>
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">Yosh:</span>
                    <span class="font-medium text-slate-900">{{ $user->age ? $user->age . ' yosh' : 'Aniqlanmadi' }}</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">Testlar:</span>
                    <span class="font-medium text-slate-900">{{ $user->initiatorSessions->count() + $user->partnerSessions->count() }} ta</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">Tug'ilgan:</span>
                    <span class="font-medium text-slate-900">{{ $user->birth_date ? $user->birth_date->format('d.m.Y') : 'Aniqlanmadi' }}</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">Ro'yxatdan:</span>
                    <span class="font-medium text-slate-900">{{ $user->created_at->format('d.m.Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
                Bekor qilish
            </a>
            <button
                type="submit"
                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-200 flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                </svg>
                Saqlash
            </button>
        </div>
    </form>
</div>
@endsection
