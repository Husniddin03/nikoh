@extends('layouts.app')

@section('title', 'Admin Panel - Juftlik tafsilotlari')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="mb-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 shadow-sm flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.couples') }}" 
               class="px-4 py-2 bg-white text-blue-600 rounded-lg shadow hover:bg-blue-50">
                ← Orqaga
            </a>

            <div>
                <h1 class="text-2xl font-bold text-blue-600">
                    Juftlik tafsilotlari
                </h1>

                <div class="flex items-center space-x-2 mt-2 text-sm">
                    <span class="bg-white px-2 py-1 rounded shadow">
                        {{ $couple->jshshir_user }}
                    </span>
                    <span>+</span>
                    <span class="bg-white px-2 py-1 rounded shadow">
                        {{ $couple->jshshir_spouse }}
                    </span>
                </div>
            </div>
        </div>

        <div class="text-right">
            <div class="text-sm text-gray-600">O'rtacha ball</div>
            <div class="text-2xl font-bold text-blue-600">{{ number_format($avgScore, 1) }}</div>
            <div class="text-sm text-gray-500">{{ round($avgPercentage) }}% moslik</div>
        </div>

        <div>
            @if($detailedTests && count($detailedTests) >= 2)
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded">
                    Tugallangan
                </span>
            @else
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded">
                    Jarayonda
                </span>
            @endif
        </div>
    </div>

    <!-- TESTLAR -->
    @foreach($detailedTests as $index => $testData)

        <div class="mb-6 bg-white rounded-xl shadow overflow-hidden">

            <!-- TEST HEADER -->
            <div class="p-4 text-white {{ $index == 0 ? 'bg-blue-500' : 'bg-purple-500' }}">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold">Test {{ $index + 1 }}</h3>
                    <div class="text-right">
                        <div>{{ $testData['total_score'] }} / {{ $testData['max_score'] }}</div>
                        <div class="text-sm opacity-90">{{ $testData['percentage'] }}%</div>
                    </div>
                </div>
                <div class="mt-2 text-sm opacity-90">
                    <div>Test holati: {{ $testData['test']->status == 'completed' ? 'Tugallangan' : 'Jarayonda' }}</div>
                    @if($testData['test']->completed_at)
                        <div>Tugatilgan: {{ $testData['test']->completed_at->format('d.m.Y H:i') }}</div>
                    @endif
                </div>
            </div>

            <!-- SECTIONS -->
            <div class="p-4 space-y-4">
                @foreach($testData['section_scores'] as $sectionData)

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-semibold text-gray-900">{{ $sectionData['section']->title }}</h4>
                            <div class="text-right">
                                <span class="font-bold text-blue-600">{{ $sectionData['score'] }} / {{ $sectionData['max_score'] }}</span>
                                <div class="text-sm text-gray-500">{{ $sectionData['percentage'] }}%</div>
                            </div>
                        </div>

                        <!-- Progress bar -->
                        <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" 
                                 style="width: {{ $sectionData['percentage'] }}%"></div>
                        </div>

                        <!-- Compatibility level -->
                        @if($sectionData['percentage'] >= 80)
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                Juda yaxshi
                            </span>
                        @elseif($sectionData['percentage'] >= 60)
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                Yaxshi
                            </span>
                        @elseif($sectionData['percentage'] >= 40)
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                Qisman
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                Kam mos
                            </span>
                        @endif
                    </div>

                @endforeach
            </div>

            <!-- TEST ACTIONS -->
            <div class="p-4 bg-gray-50 border-t flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    {{ $testData['test']->created_at->format('d.m.Y H:i') }} da boshlangan
                </div>
                <div class="space-x-2">
                    <a href="{{ route('admin.results.download.pdf', $testData['test']) }}" 
                       class="px-3 py-1 bg-purple-600 text-white text-sm rounded hover:bg-purple-700">
                        <i class="fas fa-download mr-1"></i> PDF
                    </a>
                    <a href="{{ route('admin.results.print', $testData['test']) }}" 
                       class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                        <i class="fas fa-print mr-1"></i> Chop etish
                    </a>
                </div>
            </div>

        </div>

    @endforeach

    <!-- SOLISHTIRISH -->
    @if(count($detailedTests) >= 2)

        @php
            $t1 = $detailedTests[0];
            $t2 = $detailedTests[1];

            $diff = abs($t1['total_score'] - $t2['total_score']);

            if ($diff <= 5) $status = 'Yuqori moslik';
            elseif ($diff <= 10) $status = 'Oʻrtacha moslik';
            else $status = 'Past moslik';
        @endphp

        <div class="mt-8 bg-purple-50 p-6 rounded-xl text-center">
            <h3 class="text-xl font-bold mb-4">Testlar solishtirishi</h3>

            <div class="flex justify-center space-x-6 mb-4">
                <div class="text-center">
                    <div class="text-sm text-gray-600">Test 1</div>
                    <div class="text-2xl font-bold">{{ $t1['total_score'] }}</div>
                    <div class="text-sm text-gray-500">{{ $t1['percentage'] }}%</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-600">Test 2</div>
                    <div class="text-2xl font-bold">{{ $t2['total_score'] }}</div>
                    <div class="text-sm text-gray-500">{{ $t2['percentage'] }}%</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-600">Farq</div>
                    <div class="text-2xl font-bold">{{ $diff }}</div>
                    <div class="text-sm text-gray-500">ball</div>
                </div>
            </div>

            <div class="font-bold text-lg">
                @if($diff <= 5)
                    <span class="text-green-600">{{ $status }}</span>
                @elseif($diff <= 10)
                    <span class="text-blue-600">{{ $status }}</span>
                @else
                    <span class="text-red-600">{{ $status }}</span>
                @endif
            </div>
            
            <div class="mt-3 text-sm text-gray-600">
                @if($diff <= 5)
                    Ikkala test natijalari juda o'xshash, juftlikda barqarorlik bor
                @elseif($diff <= 10)
                    Test natijalari o'rtacha farq qiladi, bu normal holat
                @else
                    Test natijalari orasida katta farq bor, qo'shimcha maslahat kerak bo'lishi mumkin
                @endif
            </div>
        </div>

    @endif

</div>
@endsection