@extends('layouts.admin')

@section('title', 'Adminni Tahrirlash')

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
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Adminni Tahrirlash</h2>
        <p class="text-slate-500 mt-1">
            <span class="inline-flex items-center gap-1.5">
                <span class="w-8 h-8 {{ $admin->is_super_admin ? 'bg-gradient-to-br from-rose-400 to-rose-500' : 'bg-gradient-to-br from-slate-400 to-slate-500' }} rounded-lg flex items-center justify-center text-white text-sm font-bold">
                    {{ substr($admin->name, 0, 1) }}
                </span>
                <span class="font-medium text-slate-700">{{ $admin->name }}</span>
                ma'lumotlarini yangilang
            </span>
        </p>
    </div>

    <!-- Form - Soft UI -->
    <form action="{{ route('admin.super.admins.update', $admin) }}" method="POST" class="bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                Ism <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $admin->name) }}"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
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
                value="{{ old('username', $admin->username) }}"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all font-mono"
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
                Yangi Parol <span class="text-slate-400 font-normal">(agar o'zgartirmoqchi bo'lsangiz)</span>
            </label>
            <input
                type="password"
                id="password"
                name="password"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                placeholder="••••••••"
            >
            <p class="mt-2 text-xs text-slate-500 flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                </svg>
                Bo'sh qoldirsangiz parol o'zgarmaydi. Kamida 8 ta belgi.
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
            <label class="relative flex items-center p-4 {{ $admin->id === auth('admin')->id() ? 'bg-slate-100 cursor-not-allowed' : 'bg-slate-50 cursor-pointer hover:bg-slate-100' }} border-2 {{ $admin->id === auth('admin')->id() ? 'border-slate-200' : 'border-slate-200 hover:border-slate-300' }} rounded-xl transition-all {{ $admin->id === auth('admin')->id() ? '' : 'has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50' }}">
                <input
                    type="checkbox"
                    name="is_super_admin"
                    value="1"
                    {{ old('is_super_admin', $admin->is_super_admin) ? 'checked' : '' }}
                    {{ $admin->id === auth('admin')->id() ? 'disabled' : '' }}
                    class="w-5 h-5 {{ $admin->id === auth('admin')->id() ? 'text-slate-400' : 'text-rose-600' }} bg-slate-100 border-slate-300 rounded focus:ring-rose-500"
                >
                <div class="ml-3">
                    <span class="text-sm font-semibold {{ $admin->id === auth('admin')->id() ? 'text-slate-500' : 'text-slate-900' }}">Super Admin huquqlari</span>
                    <p class="text-xs {{ $admin->id === auth('admin')->id() ? 'text-slate-400' : 'text-slate-500' }} mt-0.5">
                        @if($admin->id === auth('admin')->id())
                            O'zingizni super admin statusidan mahrum qila olmaysiz
                        @else
                            Super adminlar boshqa adminlarni boshqarish huquqiga ega
                        @endif
                    </p>
                </div>
                @if(!$admin->id === auth('admin')->id())
                    <svg class="absolute right-4 w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </label>
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
                @if($admin->id === auth('admin')->id())
                    <span class="ml-auto inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-medium">
                        Sizning profilingiz
                    </span>
                @endif
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">ID:</span>
                    <span class="font-medium text-slate-900">#{{ $admin->id }}</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">Status:</span>
                    <span class="font-medium {{ $admin->is_super_admin ? 'text-rose-600' : 'text-slate-600' }}">{{ $admin->is_super_admin ? 'Super Admin' : 'Admin' }}</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">Ro'yxatdan:</span>
                    <span class="font-medium text-slate-900">{{ $admin->created_at->format('d.m.Y') }}</span>
                </div>
                <div class="flex items-center gap-2 px-3 py-2 bg-white rounded-lg">
                    <span class="text-slate-500">Yangilangan:</span>
                    <span class="font-medium text-slate-900">{{ $admin->updated_at->format('d.m.Y') }}</span>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"></path>
                </svg>
                Saqlash
            </button>
        </div>
    </form>
</div>
@endsection
