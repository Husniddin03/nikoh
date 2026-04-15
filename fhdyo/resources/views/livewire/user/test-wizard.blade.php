<div class="min-h-[calc(100vh-11rem)] py-6 px-4 sm:px-6 lg:px-8 bg-slate-50">
    <div class="max-w-4xl mx-auto">
        <!-- Progress Bar - Soft UI -->
        <div class="mb-6 bg-white rounded-2xl p-4 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <div class="flex justify-between text-sm font-medium text-slate-600 mb-3">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Javob berilgan: <span class="text-slate-900 font-semibold">{{ $this->getAnsweredCount() }} / {{ $this->getTotalQuestions() }}</span>
                </span>
                <span class="text-emerald-600 font-bold">{{ round($this->getProgress(), 1) }}%</span>
            </div>
            <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                <div
                    class="h-full bg-gradient-to-r from-emerald-400 to-emerald-500 transition-all duration-500 ease-out rounded-full"
                    style="width: {{ $this->getProgress() }}%"
                ></div>
            </div>
        </div>

        <!-- Test Content -->
        @if(empty($questions))
            <div class="text-center py-12">
                <div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.08)] max-w-md mx-auto">
                    <div class="mb-6">
                        <div class="w-20 h-20 bg-rose-100 rounded-2xl mx-auto flex items-center justify-center">
                            <svg class="w-10 h-10 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Savollar topilmadi</h2>
                    <p class="text-slate-600 mb-4">Test sessiyasida savollar mavjud emas.</p>
                    <p class="text-sm text-slate-500">Iltimos, admin panelga o'tib, bo'limlar va savollarni qo'shing.</p>
                </div>
            </div>

        @elseif($isCalculating)
            <div class="text-center py-12">
                <div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.08)] max-w-md mx-auto">
                    <div class="mb-6">
                        <svg class="animate-spin mx-auto h-16 w-16 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Hisoblanmoqda...</h2>
                    <p class="text-slate-600">Natijalar tayyorlanmoqda. Iltimos, kuting.</p>
                </div>
            </div>

        @elseif($isCompleted)
            <div class="text-center py-12">
                <div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.08)] max-w-xl mx-auto">
                    <div class="mb-6">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-3">Test tugadi!</h2>
                    <p class="text-slate-600 mb-6 text-lg">Barcha savollarga javob berildi.</p>
                    <div class="bg-amber-50 rounded-xl p-5 border border-amber-200">
                        <div class="flex items-center gap-3 justify-center mb-3">
                            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-amber-800 font-semibold">Kuting...</span>
                        </div>
                        <p class="text-slate-600 text-sm mb-3">Sherigingiz javoblarni tugatishini kuting. Ikkala foydalanuvchi ham testni tugatgandan so'ng natijalar avtomatik ko'rsatiladi.</p>
                        <div class="flex items-center justify-center text-sm text-amber-600">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Kutilmoqda...
                        </div>
                    </div>
                </div>
            </div>

        @elseif($currentQuestion = $this->getCurrentQuestion())
            <div class="space-y-6" x-data="{ showQuestion: false }" x-init="setTimeout(() => showQuestion = true, 100)">
                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300"
                     :class="showQuestion ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    <div class="mb-4 flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-emerald-50 text-emerald-700 rounded-full">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"></path>
                            </svg>
                            {{ $currentQuestion['unit']['name'] }}
                        </span>
                        @if($currentQuestion['is_critical'])
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-semibold text-rose-700 bg-rose-50 rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                </svg>
                                Muhim savol
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg sm:text-xl font-semibold text-slate-900 mb-8 leading-relaxed">
                        {{ $this->currentQuestionIndex + 1 }}. {{ $currentQuestion['question'] }}
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button
                            wire:click="answerQuestion(true)"
                            wire:loading.attr="disabled"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white py-4 px-4 rounded-xl font-semibold text-base transition-all shadow-lg shadow-emerald-200 hover:shadow-xl hover:shadow-emerald-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                HA
                            </span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saqlanmoqda...
                            </span>
                        </button>
                        <button
                            wire:click="answerQuestion(false)"
                            wire:loading.attr="disabled"
                            class="bg-white hover:bg-rose-50 text-rose-600 py-4 px-4 rounded-xl font-semibold text-base border-2 border-rose-100 hover:border-rose-200 transition-all focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                YO'Q
                            </span>
                            <span wire:loading class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-rose-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saqlanmoqda...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="bg-white rounded-2xl p-8 shadow-[0_8px_30px_rgb(0,0,0,0.08)] max-w-xl mx-auto">
                    <div class="mb-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Test tugadi!</h2>
                    <p class="text-slate-600 mb-8 text-lg">Barcha savollarga javob berildi.</p>
                    @if($session->status === 'completed')
                        <a href="{{ route('user.results', $session) }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white py-3 px-6 rounded-xl font-semibold text-base transition-all shadow-lg shadow-emerald-200 hover:shadow-xl hover:shadow-emerald-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Natijalarni Ko'rish
                        </a>
                    @else
                        <div class="bg-amber-50 rounded-xl p-6 border border-amber-200">
                            <div class="flex items-center gap-3 justify-center mb-3">
                                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-amber-800 font-semibold">Kutilmoqda</span>
                            </div>
                            <p class="text-amber-700">Sherigingiz testni tugatgandan so'ng natijalar ko'rinadi.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
