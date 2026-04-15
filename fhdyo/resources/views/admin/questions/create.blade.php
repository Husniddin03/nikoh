@extends('layouts.admin')

@section('title', 'Yangi Savol')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="mb-8">
        <a href="{{ route('admin.questions.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
            </svg>
            Savollarga qaytish
        </a>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Yangi Savol Yaratish</h2>
        <p class="text-slate-500 mt-1">Yangi test savolini tizimga qo'shing</p>
    </div>

    <!-- Form - Soft UI -->
    <form action="{{ route('admin.questions.store') }}" method="POST" class="bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        @csrf

        <!-- Unit Field -->
        <div class="mb-6">
            <label for="unit_id" class="block text-sm font-medium text-slate-700 mb-2">
                Bo'lim <span class="text-rose-500">*</span>
            </label>
            <select
                id="unit_id"
                name="unit_id"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all"
                required
            >
                <option value="">Bo'limni tanlang</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }} ({{ $unit->category === 'nikoh' ? 'Nikoh' : 'Ajrim' }})
                    </option>
                @endforeach
            </select>
            @error('unit_id')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Question Field -->
        <div class="mb-6">
            <label for="question" class="block text-sm font-medium text-slate-700 mb-2">
                Savol matni <span class="text-rose-500">*</span>
            </label>
            <textarea
                id="question"
                name="question"
                rows="4"
                class="w-full px-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all resize-none"
                placeholder="Savol matnini kiriting..."
                required
            >{{ old('question') }}</textarea>
            @error('question')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Is Critical Field - Soft UI Radio Cards -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-slate-700 mb-3">Muhimligi</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="relative flex items-center p-4 bg-slate-50 border-2 border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 hover:border-slate-300 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input
                        type="radio"
                        name="is_critical"
                        value="1"
                        {{ old('is_critical') === '1' ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500"
                    >
                    <div class="ml-3">
                        <span class="text-sm font-medium text-slate-900">Muhim savol</span>
                        <p class="text-xs text-slate-500 mt-0.5">Bu savol test natijasiga katta ta'sir qiladi</p>
                    </div>
                    <svg class="absolute right-4 w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                    </svg>
                </label>
                <label class="relative flex items-center p-4 bg-slate-50 border-2 border-slate-200 rounded-xl cursor-pointer hover:bg-slate-100 hover:border-slate-300 transition-all has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50">
                    <input
                        type="radio"
                        name="is_critical"
                        value="0"
                        {{ old('is_critical') === '0' || old('is_critical') === null ? 'checked' : '' }}
                        class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500"
                    >
                    <div class="ml-3">
                        <span class="text-sm font-medium text-slate-900">Oddiy savol</span>
                        <p class="text-xs text-slate-500 mt-0.5">Standart savol, o'z ta'siri cheklangan</p>
                    </div>
                    <svg class="absolute right-4 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </label>
            </div>
            @error('is_critical')
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
            <a href="{{ route('admin.questions.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
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
