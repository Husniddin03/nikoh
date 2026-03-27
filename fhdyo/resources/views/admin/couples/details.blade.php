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
                        {{ $coupleData['couple']->jshshir_user }}
                    </span>
                    <span>+</span>
                    <span class="bg-white px-2 py-1 rounded shadow">
                        {{ $coupleData['couple']->jshshir_spouse }}
                    </span>
                </div>
            </div>
        </div>

        <div>
            @if(count($coupleData['test_results']) >= 2)
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
    @foreach($coupleData['test_results'] as $index => $test)

        @php
            $test->load(['answers.question.surveySection']);
            $sections = [];

            foreach ($test->answers as $answer) {
                $id = $answer->question->survey_section_id;

                if (!isset($sections[$id])) {
                    $sections[$id] = [
                        'title' => $answer->question->surveySection->title,
                        'score' => 0,
                        'max' => 0,
                        'answers' => []
                    ];
                }

                $sections[$id]['score'] += $answer->score;
                $sections[$id]['max'] += 2;
                $sections[$id]['answers'][] = $answer;
            }
        @endphp

        <div class="mb-6 bg-white rounded-xl shadow overflow-hidden">

            <!-- TEST HEADER -->
            <div class="p-4 text-white {{ $index == 0 ? 'bg-blue-500' : 'bg-purple-500' }}">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold">Test {{ $index + 1 }}</h3>
                    <span>{{ $test->total_score }} / {{ $test->max_score }}</span>
                </div>
            </div>

            <!-- SECTIONS -->
            <div class="p-4 space-y-4">
                @foreach($sections as $key => $section)

                    <div class="bg-gray-50 p-4 rounded">

                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-semibold">{{ $section['title'] }}</h4>
                            <span class="text-sm">
                                {{ $section['score'] }} / {{ $section['max'] }}
                            </span>
                        </div>

                        <!-- DROPDOWN -->
                        <button onclick="toggleDropdown('d{{ $key }}{{ $index }}')" 
                                class="w-full text-left bg-white border px-3 py-2 rounded">
                            Javoblarni ko‘rish
                        </button>

                        <div id="d{{ $key }}{{ $index }}" 
                             class="hidden mt-2 bg-white border rounded p-3 space-y-2">

                            @foreach($section['answers'] as $answer)
                                <div class="border-b pb-2 text-sm">
                                    <b>{{ $answer->question->order }}.</b>
                                    {{ $answer->question->question_text }}

                                    <div class="mt-1 flex justify-between">
                                        <span>
                                            @if($answer->answer === 'yes') ✅ Ha
                                            @elseif($answer->answer === 'partially') ⚠️ Qisman
                                            @else ❌ Yo‘q
                                            @endif
                                        </span>

                                        <span>{{ $answer->score }} ball</span>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                @endforeach
            </div>
        </div>

    @endforeach

    <!-- SOLISHTIRISH -->
    @if(count($coupleData['test_results']) >= 2)

        @php
            $t1 = $coupleData['test_results'][0];
            $t2 = $coupleData['test_results'][1];

            $diff = abs($t1->total_score - $t2->total_score);

            if ($diff <= 5) $status = 'Yuqori moslik';
            elseif ($diff <= 10) $status = 'O‘rtacha moslik';
            else $status = 'Past moslik';
        @endphp

        <div class="mt-8 bg-purple-50 p-6 rounded-xl text-center">
            <h3 class="text-xl font-bold mb-4">Solishtirish</h3>

            <div class="flex justify-center space-x-6 mb-4">
                <div>{{ $t1->total_score }}</div>
                <div>{{ $t2->total_score }}</div>
                <div>Farq: {{ $diff }}</div>
            </div>

            <div class="font-bold text-lg">{{ $status }}</div>
        </div>

    @endif

</div>

<script>
function toggleDropdown(id) {
    document.getElementById(id).classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('button')) {
        document.querySelectorAll('[id^="d"]').forEach(el => el.classList.add('hidden'));
    }
});
</script>

@endsection