<div class="min-h-[calc(100vh-11rem)] flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8 bg-slate-50">
    <div class="w-full max-w-md">
        <!-- Logo/Header - Soft UI -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-500 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg shadow-emerald-200">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-slate-900">Nikoh Testi</h2>
            <p class="mt-2 text-slate-500">Ikkala JSHSHIRni kiriting va testni boshlang</p>
        </div>

        <form wire:submit.prevent="submit" class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.08)] space-y-5">
            <!-- Test Category Selection -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-3">
                    Test turini tanlang <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <label class="cursor-pointer">
                        <input
                            type="radio"
                            wire:model.live="category"
                            value="nikoh"
                            class="peer sr-only"
                            :disabled="$isProcessing"
                        >
                        <div class="bg-slate-50 border-2 border-slate-200 rounded-xl p-4 text-center transition-all peer-checked:bg-emerald-500 peer-checked:border-emerald-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-emerald-200 peer-disabled:opacity-50 hover:border-emerald-300">
                            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-2 peer-checked:bg-white/20">
                                <svg class="w-5 h-5 text-emerald-600 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div class="text-base font-semibold">Nikoh</div>
                            <div class="text-xs mt-1 opacity-75">Muvofiqlik testi</div>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input
                            type="radio"
                            wire:model.live="category"
                            value="ajrim"
                            class="peer sr-only"
                            :disabled="$isProcessing"
                        >
                        <div class="bg-slate-50 border-2 border-slate-200 rounded-xl p-4 text-center transition-all peer-checked:bg-amber-500 peer-checked:border-amber-500 peer-checked:text-white peer-checked:shadow-lg peer-checked:shadow-amber-200 peer-disabled:opacity-50 hover:border-amber-300">
                            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-2 peer-checked:bg-white/20">
                                <svg class="w-5 h-5 text-amber-600 peer-checked:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="text-base font-semibold">Ajrim</div>
                            <div class="text-xs mt-1 opacity-75">Ajrim sabablari</div>
                        </div>
                    </label>
                </div>
                @error('category')
                    <div class="mt-2 p-2 bg-rose-50 border border-rose-200 rounded-xl">
                        <p class="text-sm text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    </div>
                @enderror
            </div>

            <!-- My JSHSHIR Input -->
            <div>
                <label for="myJshshir" class="block text-sm font-medium text-slate-700 mb-2">
                    Sizning JSHSHIRingiz <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25h-15A2.25 2.25 0 002.25 6v11.25A2.25 2.25 0 004.5 19.5z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="myJshshir"
                        wire:model.live="my_jshshir"
                        maxlength="14"
                        placeholder="14 ta raqam"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all font-mono text-base {{ $errors->has('my_jshshir') ? 'border-rose-500' : '' }}"
                        :disabled="$isProcessing"
                    >
                </div>
                @error('my_jshshir')
                    <div class="mt-2 p-2 bg-rose-50 border border-rose-200 rounded-xl">
                        <p class="text-sm text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    </div>
                @enderror
            </div>

            <!-- Partner JSHSHIR Input -->
            <div>
                <label for="partnerJshshir" class="block text-sm font-medium text-slate-700 mb-2">
                    Sherigingizning JSHSHIRi <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="partnerJshshir"
                        wire:model.live="partner_jshshir"
                        maxlength="14"
                        placeholder="14 ta raqam"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all font-mono text-base {{ $errors->has('partner_jshshir') ? 'border-rose-500' : '' }}"
                        :disabled="$isProcessing"
                    >
                </div>
                @error('partner_jshshir')
                    <div class="mt-2 p-2 bg-rose-50 border border-rose-200 rounded-xl">
                        <p class="text-sm text-rose-600 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button
                    type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 px-4 rounded-xl font-semibold text-base transition-all shadow-lg shadow-emerald-200 hover:shadow-xl hover:shadow-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="$isProcessing"
                >
                    @if($isProcessing)
                        <span class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Ishlanmoqda...
                        </span>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Testni Boshlash
                    @endif
                </button>
            </div>
        </form>

        <!-- Instructions - Soft UI -->
        <div class="mt-6 p-4 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-8 h-8 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-slate-900">Qanday ishlash kerak:</h3>
            </div>
            <ol class="text-sm text-slate-600 space-y-2">
                <li class="flex items-start gap-2">
                    <span class="w-5 h-5 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 font-semibold text-xs flex-shrink-0">1</span>
                    <span>Ikkala JSHSHIRni to'g'ri kiriting (14 ta raqam)</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-5 h-5 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 font-semibold text-xs flex-shrink-0">2</span>
                    <span>JSHSHIR tekshirilgandan so'ng test avtomatik boshlanadi</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-5 h-5 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 font-semibold text-xs flex-shrink-0">3</span>
                    <span>Har bir savolga "Ha" yoki "Yo'q" deb javob bering</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="w-5 h-5 bg-emerald-100 rounded-lg flex items-center justify-center text-emerald-600 font-semibold text-xs flex-shrink-0">4</span>
                    <span>Test tugagandan so'ng natijalarni ko'rasiz</span>
                </li>
            </ol>
        </div>
    </div>
</div>
