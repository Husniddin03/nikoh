@extends('layouts.admin')

@section('title', 'Yangi Bo\'lim')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="mb-8">
        <a href="{{ route('admin.units.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
            </svg>
            Bo'limlarga qaytish
        </a>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Yangi Bo'lim Yaratish</h2>
        <p class="text-slate-500 mt-1">Yangi test bo'limini tizimga qo'shing</p>
    </div>

    <!-- Form - Soft UI -->
    <form action="{{ route('admin.units.store') }}" method="POST" class="bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        @csrf

        <!-- Name Field -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                Bo'lim nomi <span class="text-rose-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                placeholder="Masalan: Aholini ro'yxatga olish"
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

        <!-- Category Field -->
        <div class="mb-6">
            <label for="category" class="block text-sm font-medium text-slate-700 mb-2">
                Kategoriya <span class="text-rose-500">*</span>
            </label>
            <select
                id="category"
                name="category"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all"
                required
            >
                <option value="">Kategoriyani tanlang</option>
                <option value="nikoh" {{ old('category') === 'nikoh' ? 'selected' : '' }}>Nikoh</option>
                <option value="ajrim" {{ old('category') === 'ajrim' ? 'selected' : '' }}>Ajrim</option>
            </select>
            @error('category')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="mb-8">
            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                Tavsif
            </label>
            <textarea
                id="description"
                name="description"
                rows="4"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all resize-none"
                placeholder="Bo'lim haqida qisqacha ma'lumot..."
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.units.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
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
