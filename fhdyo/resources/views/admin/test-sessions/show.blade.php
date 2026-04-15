@extends('layouts.admin')

@section('title', 'Juftlik #' . $testSession->id)

@section('content')
<style>
    @media print {
        .no-print { display: none !important; }
        .print-only { display: block !important; }
        body { background: white !important; }
        .shadow-lg, .shadow-md { box-shadow: none !important; }
    }
    .print-only { display: none; }
</style>

<div id="printable-content">
    <!-- Header with Back & PDF Buttons -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-8 no-print">
        <a href="{{ route('admin.test-sessions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Orqaga
        </a>
        <div class="flex gap-3">
            <a href="{{ route('admin.test-sessions.pdf', $testSession) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                PDF yuklash
            </a>
        </div>
    </div>

    <!-- Report Title (Print Only) -->
    <div class="print-only mb-8 text-center border-b-2 border-black pb-4">
        <h1 class="text-3xl font-bold text-black">NIKOH TEST NATIJASI</h1>
        <p class="text-gray-600 mt-2">Juftlik #{{ $testSession->id }} | {{ $testSession->created_at->format('d.m.Y H:i') }}</p>
    </div>

    <!-- Main Info Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white px-6 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Juftlik #{{ $testSession->id }}</h2>
                    <p class="text-gray-300 mt-1">{{ $testSession->created_at->format('d.m.Y H:i') }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $testSession->status === 'completed' ? 'bg-green-500 text-white' : ($testSession->status === 'in_progress' ? 'bg-yellow-500 text-white' : 'bg-gray-500 text-white') }}">
                    {{ $testSession->status === 'completed' ? '✓ Tugallangan' : ($testSession->status === 'in_progress' ? '⏳ Jarayonda' : '⏸ Kutilmoqda') }}
                </span>
            </div>
        </div>

        <!-- Users Info Grid -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Initiator Card -->
                <div class="bg-gradient-to-br {{ $testSession->initiator->gender === 'male' ? 'from-blue-50 to-blue-100 border-blue-200' : 'from-pink-50 to-pink-100 border-pink-200' }} rounded-lg p-5 border-2">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Boshlovchi</span>
                        <span class="text-2xl">{{ $testSession->initiator->gender === 'male' ? '♂' : '♀' }}</span>
                    </div>
                    <p class="font-mono text-xl text-gray-900 mb-2">{{ $testSession->initiator->jshshir }}</p>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span class="px-2 py-1 rounded {{ $testSession->initiator->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $testSession->initiator->gender === 'male' ? 'Erkak' : 'Ayol' }}
                        </span>
                        <span>{{ $testSession->initiator->birth_date ? $testSession->initiator->birth_date->format('d.m.Y') : '?' }}</span>
                        <span class="font-semibold">({{ $testSession->initiator->age ?? '?' }} yosh)</span>
                    </div>
                    @if($testSession->isInitiatorCompleted())
                        <div class="mt-3 flex items-center text-green-600 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Testni tugatgan
                        </div>
                    @endif
                </div>

                <!-- Partner Card -->
                <div class="bg-gradient-to-br {{ $testSession->partner->gender === 'male' ? 'from-blue-50 to-blue-100 border-blue-200' : 'from-pink-50 to-pink-100 border-pink-200' }} rounded-lg p-5 border-2">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Sherik</span>
                        <span class="text-2xl">{{ $testSession->partner->gender === 'male' ? '♂' : '♀' }}</span>
                    </div>
                    <p class="font-mono text-xl text-gray-900 mb-2">{{ $testSession->partner->jshshir }}</p>
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span class="px-2 py-1 rounded {{ $testSession->partner->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $testSession->partner->gender === 'male' ? 'Erkak' : 'Ayol' }}
                        </span>
                        <span>{{ $testSession->partner->birth_date ? $testSession->partner->birth_date->format('d.m.Y') : '?' }}</span>
                        <span class="font-semibold">({{ $testSession->partner->age ?? '?' }} yosh)</span>
                    </div>
                    @if($testSession->isPartnerCompleted())
                        <div class="mt-3 flex items-center text-green-600 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Testni tugatgan
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats Row -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-6 pt-6 border-t border-gray-200">
                <div class="text-center p-3 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-gray-900">{{ isset($initiatorResults) ? $initiatorResults->count() : 0 }}</p>
                    <p class="text-xs text-gray-500 uppercase">Savollar soni</p>
                </div>
                <div class="text-center p-3 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">
                        {{ isset($answersComparison) ? collect($answersComparison)->where('matched', true)->count() : 0 }}
                    </p>
                    <p class="text-xs text-green-600 uppercase">Mos javoblar</p>
                </div>
                <div class="text-center p-3 bg-red-50 rounded-lg">
                    <p class="text-2xl font-bold text-red-600">
                        {{ isset($answersComparison) ? collect($answersComparison)->where('matched', false)->count() : 0 }}
                    </p>
                    <p class="text-xs text-red-600 uppercase">Mos emas</p>
                </div>
                <div class="text-center p-3 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">{{ $compatibility ?? 0 }}%</p>
                    <p class="text-xs text-blue-600 uppercase">Muvofiqlik</p>
                </div>
                <div class="text-center p-3 bg-purple-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">
                        {{ isset($groupedAnswers) ? $groupedAnswers->count() : 0 }}
                    </p>
                    <p class="text-xs text-purple-600 uppercase">Bo'limlar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Compatibility Score Card -->
    @if($testSession->status === 'completed')
        <div class="bg-white rounded-xl shadow-lg border-2 {{ $compatibility >= 70 ? 'border-green-400' : ($compatibility >= 40 ? 'border-yellow-400' : 'border-red-400') }} overflow-hidden mb-8">
            <div class="p-8 text-center">
                <h3 class="text-xl font-semibold text-gray-700 mb-6">Muvofiqlik Natijasi</h3>
                
                <!-- Circular Progress Style -->
                <div class="relative inline-block mb-4">
                    <svg class="w-40 h-40 transform -rotate-90">
                        <circle cx="80" cy="80" r="70" stroke="#e5e7eb" stroke-width="12" fill="none"></circle>
                        <circle cx="80" cy="80" r="70" 
                            stroke="{{ $compatibility >= 70 ? '#10b981' : ($compatibility >= 40 ? '#f59e0b' : '#ef4444') }}" 
                            stroke-width="12" fill="none" 
                            stroke-dasharray="440" 
                            stroke-dashoffset="{{ 440 - (440 * $compatibility / 100) }}"></circle>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-4xl font-bold {{ $compatibility >= 70 ? 'text-green-600' : ($compatibility >= 40 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ $compatibility }}%
                        </span>
                    </div>
                </div>

                <!-- Verdict -->
                <div class="mt-4">
                    @if($compatibility >= 70)
                        <div class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-full text-lg font-semibold">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            A'lo muvofiqlik! Juftlik juda mos.
                        </div>
                    @elseif($compatibility >= 40)
                        <div class="inline-flex items-center px-6 py-3 bg-yellow-100 text-yellow-800 rounded-full text-lg font-semibold">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            O'rta muvofiqlik. Muzokaralar o'tkazish kerak.
                        </div>
                    @else
                        <div class="inline-flex items-center px-6 py-3 bg-red-100 text-red-800 rounded-full text-lg font-semibold">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Past muvofiqlik. Ehtiyot bo'ling.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Detailed Answers with Comparison -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-wrap justify-between items-center gap-4">
                <h3 class="text-lg font-semibold text-gray-800">Javoblar Taqqoslash</h3>
                <div class="flex items-center gap-4 text-sm">
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-green-500"></span>
                        Mos javoblar
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        Mos kelmaydigan javoblar
                    </span>
                </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">
                {{ $testSession->initiator->jshshir }} (Boshlovchi) vs {{ $testSession->partner->jshshir }} (Sherik)
            </p>
        </div>
        
        @if(isset($groupedAnswers) && $groupedAnswers->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($groupedAnswers as $unitName => $answers)
                    <!-- Unit Header -->
                    <div class="bg-gradient-to-r from-gray-100 to-gray-50 px-6 py-3 border-b border-gray-200">
                        <h4 class="font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            {{ $unitName }}
                            <span class="ml-2 text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full">{{ $answers->count() }} ta savol</span>
                        </h4>
                    </div>
                    
                    <!-- Answers Table Header -->
                    <div class="hidden md:grid md:grid-cols-12 bg-gray-50 px-6 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <div class="col-span-6">Savol</div>
                        <div class="col-span-3 text-center">Boshlovchi</div>
                        <div class="col-span-3 text-center">Sherik</div>
                    </div>
                    
                    <!-- Answers Rows -->
                    @foreach($answers as $index => $answer)
                        <div class="px-6 py-4 hover:bg-gray-50 transition {{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50/30' }} {{ $answer['matched'] ? 'border-l-4 border-green-400' : 'border-l-4 border-red-400' }}">
                            <!-- Mobile View -->
                            <div class="md:hidden mb-3">
                                <p class="font-medium text-gray-800 mb-2">{{ $answer['question']->question }}</p>
                                <div class="flex justify-between text-sm">
                                    <span class="flex items-center gap-2">
                                        <span class="text-gray-500">Boshlovchi:</span>
                                        @if($answer['initiator_answer'] === true)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Ha ✓</span>
                                        @elseif($answer['initiator_answer'] === false)
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Yo'q ✗</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded">-</span>
                                        @endif
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <span class="text-gray-500">Sherik:</span>
                                        @if($answer['partner_answer'] === true)
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Ha ✓</span>
                                        @elseif($answer['partner_answer'] === false)
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Yo'q ✗</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded">-</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Desktop View -->
                            <div class="hidden md:grid md:grid-cols-12 items-center gap-4">
                                <div class="col-span-6">
                                    <p class="text-gray-800">{{ $answer['question']->question }}</p>
                                </div>
                                <div class="col-span-3 text-center">
                                    @if($answer['initiator_answer'] === true)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Ha
                                        </span>
                                    @elseif($answer['initiator_answer'] === false)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            Yo'q
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-500">-</span>
                                    @endif
                                </div>
                                <div class="col-span-3 text-center">
                                    @if($answer['partner_answer'] === true)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Ha
                                        </span>
                                    @elseif($answer['partner_answer'] === false)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            Yo'q
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-500">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        @else
            <div class="px-6 py-12 text-center text-gray-500">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-lg">Hali javoblar yo'q</p>
                <p class="text-sm mt-2">Foydalanuvchilar testni topshirishlari kerak</p>
            </div>
        @endif
    </div>

    <!-- Footer Actions -->
    <div class="flex flex-wrap justify-between items-center gap-4 no-print">
        <form action="{{ route('admin.test-sessions.destroy', $testSession) }}" method="POST" onsubmit="return confirm('Juftlikni o\'chirishni hohlaysizmi? Bu amalni qaytarib bo\'lmaydi.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Juftlikni o'chirish
            </button>
        </form>

        <div class="text-sm text-gray-500">
            Test ID: {{ $testSession->id }} | Sana: {{ $testSession->created_at->format('d.m.Y') }}
        </div>
    </div>

    <!-- Print Footer -->
    <div class="print-only mt-8 pt-4 border-t border-gray-300 text-center text-sm text-gray-500">
        <p>Hujjat avtomatik tarzda yaratildi | {{ now()->format('d.m.Y H:i') }}</p>
        <p class="mt-1">Tizim: Nikoh Test Platformasi</p>
    </div>
</div>
@endsection
