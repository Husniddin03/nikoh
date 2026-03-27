@extends('layouts.app')

@section('title', 'Chop Etish - Test Natijasi')

@section('content')
<div class="p-4 lg:p-6">
    <div class="mb-6">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Test Natjasini Chop Etish</h1>
        <p class="text-gray-600 text-sm lg:text-base">Test natijasini PDF formatda yuklab olish yoki bevosita chop etish</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <!-- Test Info -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Test #{{ $testResult->id }}</h2>
                    <p class="text-sm text-gray-600">
                        {{ $testResult->couple->jshshir_user }} & {{ $testResult->couple->jshshir_spouse }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $testResult->created_at->format('d.m.Y H:i') }}
                    </p>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-500 mb-1">Umumiy Ball</div>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $testResult->total_score }} / {{ $testResult->max_score }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ round(($testResult->total_score / $testResult->max_score) * 100) }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Download PDF -->
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-download text-blue-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900">PDF Yuklab Olish</h3>
                        <p class="text-sm text-gray-600">Faylni kompyuterga saqlang</p>
                    </div>
                </div>
                <a href="{{ route('admin.results.download.pdf', $testResult->id) }}" 
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors inline-block text-center">
                    <i class="fas fa-download mr-2"></i>PDF Yuklab Olish
                </a>
            </div>

            <!-- Print PDF -->
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <i class="fas fa-print text-green-600 text-xl mr-3"></i>
                    <div>
                        <h3 class="font-semibold text-gray-900">Bevosita Chop Etish</h3>
                        <p class="text-sm text-gray-600">Printerga yuborish</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <button onclick="printPDF()" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-print mr-2"></i>Chop Etish
                    </button>
                    <button onclick="downloadAndPrint()" 
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        <i class="fas fa-external-link-alt mr-2"></i>Yangi oynada ochish
                    </button>
                </div>
            </div>
        </div>

        <!-- Preview -->
        <div class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                <i class="fas fa-eye text-gray-600 mr-2"></i>
                Oldindan Ko'rish
            </h3>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <i class="fas fa-file-pdf text-6xl text-red-500 mb-3"></i>
                <p class="text-sm text-gray-600 mb-3">
                    "Test Natijasi #{{ $testResult->id }}" PDF fayli
                </p>
                <div class="text-xs text-gray-500">
                    <p>Fayl hajmi: taxminan 150-200 KB</p>
                    <p>Sahifalar soni: 1 bet</p>
                    <p>Format: A4, portret</p>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h4 class="font-semibold text-blue-900 mb-2">
                <i class="fas fa-info-circle mr-2"></i>Chop Etish Yo'riqnomasi
            </h4>
            <ul class="text-sm text-blue-800 space-y-1">
                <li>• PDF yuklab olish uchun "PDF Yuklab Olish" tugmasini bosing</li>
                <li>• Bevosita chop etish uchun "Chop Etish" tugmasini bosing</li>
                <li>• Agar chop etish ishlamasa, "Yangi oynada ochish" tugmasini bosing</li>
                <li>• Chop etishdan oldin printer sozlamalarini tekshiring</li>
                <li>• PDF fayli yuqori sifatda va professional ko'rinishga ega</li>
                <li>• Fayl o'zbek tilida va standart formatda tayyorlangan</li>
            </ul>
        </div>
    </div>
</div>

<script>
function printPDF() {
    // Create hidden iframe for PDF
    const iframe = document.createElement('iframe');
    iframe.style.display = 'none';
    iframe.src = '{{ asset("storage/temp/" . $filename) }}';
    
    document.body.appendChild(iframe);
    
    iframe.onload = function() {
        // Wait for PDF to load, then print
        setTimeout(function() {
            try {
                iframe.contentWindow.print();
            } catch (error) {
                // Fallback: open in new window
                window.open('{{ asset("storage/temp/" . $filename) }}', '_blank');
            }
            // Remove iframe after printing
            setTimeout(function() {
                if (document.body.contains(iframe)) {
                    document.body.removeChild(iframe);
                }
            }, 1000);
        }, 1000);
    };
    
    // Handle error
    iframe.onerror = function() {
        alert('PDF faylini yuklashda xatolik yuz berdi. Iltimos, avval PDF yuklab oling.');
        if (document.body.contains(iframe)) {
            document.body.removeChild(iframe);
        }
    };
}

// Alternative: direct download and print
function downloadAndPrint() {
    window.open('{{ route('admin.results.download.pdf', $testResult->id) }}', '_blank');
}
</script>
@endsection
