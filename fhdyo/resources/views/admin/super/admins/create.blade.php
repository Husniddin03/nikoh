@extends('layouts.admin')

@section('title', 'Yangi Admin')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="mb-8">
        <a href="{{ route('admin.super.admins.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
            </svg>
            Adminlarga qaytish
        </a>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Yangi Admin Yaratish</h2>
        <p class="text-slate-500 mt-1">Yangi administrator qo'shing</p>
    </div>

    <!-- Form - Soft UI -->
    <form action="{{ route('admin.super.admins.store') }}" method="POST" class="bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        @csrf

        <!-- Name Field -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                Ism <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                placeholder="Masalan: John Doe"
                required
            >
            @error('name')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Username Field -->
        <div class="mb-6">
            <label for="username" class="block text-sm font-medium text-slate-700 mb-2">
                Username <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="username"
                name="username"
                value="{{ old('username') }}"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-mono"
                placeholder="admin_username"
                required
            >
            @error('username')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                Parol <span class="text-rose-500">*</span>
            </label>
            <input
                type="password"
                id="password"
                name="password"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                placeholder="••••••••"
                required
            >
            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path>
                </svg>
                Kamida 8 ta belgi
            </p>
            @error('password')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Super Admin Checkbox - Soft UI -->
        <div class="mb-6">
            <label class="relative flex items-center p-4 bg-slate-50 border-2 border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 hover:border-slate-300 transition-all has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50">
                <input
                    type="checkbox"
                    name="is_super_admin"
                    value="1"
                    {{ old('is_super_admin') ? 'checked' : '' }}
                    class="w-5 h-5 text-rose-600 bg-slate-100 border-slate-300 rounded focus:ring-rose-500"
                >
                <div class="ml-3">
                    <span class="text-sm font-semibold text-slate-900">Super Admin huquqlari</span>
                    <p class="text-xs text-slate-500 mt-0.5">Super adminlar boshqa adminlarni boshqarish huquqiga ega</p>
                </div>
                <svg class="absolute right-4 w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </label>
        </div>

        <!-- Info Note - Soft UI -->
        <div class="mb-8 p-5 bg-blue-50 rounded-xl border border-blue-100">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-blue-900 mb-2">Eslatma:</h4>
                    <ul class="text-sm text-blue-700 space-y-1.5">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                            Yangi admin darhol tizimga kirish huquqiga ega bo'ladi
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                            Super adminlar boshqa adminlarni yaratish, tahrirlash va o'chirish huquqiga ega
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                            Oddiy adminlar faqat kontentni boshqaradi
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.super.admins.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
                Bekor qilish
            </a>
            <button
                type="submit"
                class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-200 flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Yaratish
            </button>
        </div>
    </form>
</div>
@endsection
