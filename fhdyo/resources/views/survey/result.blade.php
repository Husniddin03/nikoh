@extends('layouts.app')

@section('title', 'Nikohga Sorovnoma - Natijalar')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-8">
                <h1 class="text-3xl font-bold mb-2">Test Natijalari</h1>
                <p class="text-blue-100">Sizning juftlik bo'yicha moslik darajangiz</p>
            </div>

            <div class="p-6">
                <!-- Overall Score -->
                <div class="text-center mb-8">
                    <div class="inline-block">
                        <div class="text-6xl font-bold text-blue-600 mb-2">
                            {{ $testResult->total_score }} / {{ $testResult->max_score }}
                        </div>
                        <div class="text-2xl font-semibold text-gray-800 mb-2">
                            {{ $testResult->compatibility_level }}
                        </div>
                        <div class="w-64 bg-gray-200 rounded-full h-4 mx-auto">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-4 rounded-full" 
                                 style="width: {{ ($testResult->total_score / $testResult->max_score) * 100 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Participants Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-blue-800 mb-2">Test topshiruvchi</h3>
                        <p class="text-gray-700"><strong>JSHSHIR:</strong> {{ $testResult->couple->jshshir_user }}</p>
                    </div>
                    
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-purple-800 mb-2">Jufti</h3>
                        <p class="text-gray-700"><strong>JSHSHIR:</strong> {{ $testResult->couple->jshshir_spouse }}</p>
                    </div>
                </div>

                <!-- Section Scores -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Bo'limlar bo'yicha natijalar</h2>
                    <div class="space-y-4">
                        @foreach ($sectionScores as $sectionScore)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="font-medium text-gray-800">{{ $sectionScore['section']->title }}</h3>
                                    <span class="text-sm text-gray-600">
                                        {{ $sectionScore['score'] }} / {{ $sectionScore['max_score'] }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full transition-all duration-500" 
                                         style="width: {{ ($sectionScore['score'] / $sectionScore['max_score']) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Partner Comparison -->
                @if($partnerTest && $comparison)
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 mb-8">
                        <h3 class="font-semibold text-purple-800 mb-4">
                            <i class="fas fa-balance-scale mr-2"></i>
                            Juftingiz bilan solishtirish
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-sm text-gray-600">Sizning ballaringiz</div>
                                <div class="text-2xl font-bold text-blue-600">{{ $comparison['person1_score'] }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-sm text-gray-600">Juftingiz ballari</div>
                                <div class="text-2xl font-bold text-purple-600">{{ $comparison['person2_score'] }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-sm text-gray-600">Farq</div>
                                <div class="text-2xl font-bold {{ $comparison['score_difference'] <= 5 ? 'text-green-600' : ($comparison['score_difference'] <= 10 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $comparison['score_difference'] }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mb-4">
                            <span class="px-4 py-2 inline-flex text-lg font-semibold rounded-full 
                                @if($comparison['compatibility_rating'] === 'Juda yuqori moslik') bg-green-100 text-green-800 
                                @elseif($comparison['compatibility_rating'] === 'Yuqori moslik') bg-blue-100 text-blue-800 
                                @elseif($comparison['compatibility_rating'] === 'O\'rtacha moslik') bg-yellow-100 text-yellow-800 
                                @else bg-red-100 text-red-800 @endif">
                                {{ $comparison['compatibility_rating'] }}
                            </span>
                        </div>
                        
                        <div class="bg-white rounded-lg p-4">
                            <p class="text-sm text-gray-700">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                {{ $comparison['recommendation'] }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Recommendations -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                    <h3 class="font-semibold text-yellow-800 mb-3">Tavsiyalar</h3>
                    <div class="text-sm text-yellow-700 space-y-2">
                        @if($testResult->total_score < 25)
                            <p>• Past natijalar chiqsa, juftliklar o'zaro suhbat, psixologik maslahat yoki nikohdan oldingi maslahat dasturlaridan foydalanishlari mumkin.</p>
                            <p>• Bu test faqat yo'naltirish uchun; qat'iy hukm emas.</p>
                        @else
                            <p>• Sizning juftlikdingiz yaxshi mos keladi. Biroq, har doim o'zaro muloqotni rivojlantirib boring.</p>
                            <p>• Oilaviy hayotda muvaffaqiyat uchun bir-biringizga hurmat va tushunish muhim.</p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap justify-center gap-3">
                    <button onclick="window.print()" class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="fas fa-print mr-2"></i> Sahifani chop etish
                    </button>
                    
                    <a href="{{ route('admin.results.download.pdf', $testResult) }}" 
                       class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <i class="fas fa-download mr-2"></i> PDF yuklab olish
                    </a>
                    
                    <a href="{{ route('admin.results.print', $testResult) }}" 
                       class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-file-pdf mr-2"></i> PDF chop etish
                    </a>
                    
                    <a href="{{ route('survey.reset', $testResult) }}" 
                       class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <i class="fas fa-redo mr-2"></i> Qayta test
                    </a>
                    
                    <a href="{{ route('survey.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i> Yangi test
                    </a>
                    
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('admin.couples.show', $testResult->couple) }}" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-chart-bar mr-2"></i> Admin panel
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
