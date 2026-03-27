@extends('layouts.app')

@section('title', 'Nikohga Sorovnoma - Test')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h1 class="text-2xl font-bold">Nikohga Sorovnoma</h1>
                <p class="text-blue-100">Iltimos, barcha savollarga javob bering</p>
            </div>

            <form action="{{ route('survey.submit', $testResult) }}" method="POST" class="p-6">
                @csrf
                
                @foreach ($sections as $section)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b-2 border-blue-200">
                            {{ $section->title }}
                        </h2>
                        
                        <div class="space-y-6">
                            @foreach ($section->activeQuestions as $question)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="font-medium text-gray-700 mb-3">
                                        <span class="text-blue-600 font-bold">{{ $question->order }}.</span>
                                        {{ $question->question_text }}
                                    </p>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center space-x-3 cursor-pointer hover:bg-blue-50 p-2 rounded">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="yes" required
                                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                            <span class="text-gray-700">Ha</span>
                                            <span class="text-sm text-gray-500">(2 ball)</span>
                                        </label>
                                        
                                        <label class="flex items-center space-x-3 cursor-pointer hover:bg-blue-50 p-2 rounded">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="partially" required
                                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                            <span class="text-gray-700">Qisman</span>
                                            <span class="text-sm text-gray-500">(1 ball)</span>
                                        </label>
                                        
                                        <label class="flex items-center space-x-3 cursor-pointer hover:bg-blue-50 p-2 rounded">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="no" required
                                                   class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                            <span class="text-gray-700">Yo'q</span>
                                            <span class="text-sm text-gray-500">(0 ball)</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-blue-800 mb-2">Baholash tizimi:</h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Har bir savolga javob: "Ha" (2 ball), "Qisman" (1 ball), "Yo'q" (0 ball)</li>
                        <li>• Har bir bo'limda maksimal ball: 100</li>
                        <li>• Jami maksimal ball: 500</li>
                    </ul>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" onclick="confirmCancel()" 
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Bekor qilish
                    </button>
                    
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Testni yakunlash
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmCancel() {
    if (confirm('Testni bekor qilishni xohlaysizmi? Barcha javoblar saqlanmaydi.')) {
        window.location.href = '{{ route("survey.index") }}';
    }
}

// Auto-save functionality
let autoSaveTimer;
document.querySelectorAll('input[type="radio"]').forEach(input => {
    input.addEventListener('change', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            // Here you could implement auto-save to localStorage
            console.log('Auto-saving...');
        }, 2000);
    });
});
</script>
@endsection
