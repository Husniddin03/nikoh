@extends('layouts.admin')

@section('title', 'Yangi Juftlik')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="mb-8">
        <a href="{{ route('admin.test-sessions.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"></path>
            </svg>
            Juftliklarga qaytish
        </a>
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Yangi Juftlik Yaratish</h2>
        <p class="text-slate-500 mt-1">Ikki foydalanuvchini birlashtiring</p>
    </div>

    <!-- Form - Soft UI -->
    <form action="{{ route('admin.test-sessions.store') }}" method="POST" class="bg-white rounded-2xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
        @csrf

        <!-- Initiator Field -->
        <div class="mb-6">
            <label for="initiator_id" class="block text-sm font-medium text-slate-700 mb-2">
                Boshlovchi (Asosiy foydalanuvchi) <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                        1
                    </div>
                </div>
                <select
                    id="initiator_id"
                    name="initiator_id"
                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all"
                    required
                >
                    <option value="">Foydalanuvchini tanlang</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('initiator_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->jshshir }} - {{ $user->gender === 'male' ? 'Erkak' : 'Ayol' }}, {{ $user->age ?? '?' }} yosh
                        </option>
                    @endforeach
                </select>
            </div>
            @error('initiator_id')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Partner Field -->
        <div class="mb-6">
            <label for="partner_id" class="block text-sm font-medium text-slate-700 mb-2">
                Sherik (Juft) <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <div class="w-8 h-8 bg-gradient-to-br from-rose-400 to-rose-500 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                        2
                    </div>
                </div>
                <select
                    id="partner_id"
                    name="partner_id"
                    class="w-full pl-12 pr-4 py-3 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all"
                    required
                >
                    <option value="">Foydalanuvchini tanlang</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('partner_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->jshshir }} - {{ $user->gender === 'male' ? 'Erkak' : 'Ayol' }}, {{ $user->age ?? '?' }} yosh
                        </option>
                    @endforeach
                </select>
            </div>
            @error('partner_id')
                <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
            @error('initiator_id')
                @if(strpos($message, 'different') !== false)
                    <p class="mt-2 text-sm text-rose-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Boshlovchi va sherik bir xil bo'lmasligi kerak
                    </p>
                @endif
            @enderror
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
                            Juftlik yaratilganda avtomatik kirish kodi yaratiladi
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                            Har ikki foydalanuvchi testni to'liq topshirishi kerak
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span>
                            Test tugagach natijalar ko'rinadi
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.test-sessions.index') }}" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
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
