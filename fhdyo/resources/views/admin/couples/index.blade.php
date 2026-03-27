@extends('layouts.app')

@section('title', 'Admin Panel - Juftliklar')

@section('content')
<div class="p-4 lg:p-6">
    <div class="mb-4 lg:mb-6">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Juftliklar</h1>
        <p class="text-gray-600 text-sm lg:text-base">Tizimdagi barcha juftliklar ro'yxati va tahlili</p>
    </div>

    <!-- Mobile Cards View -->
    <div class="lg:hidden space-y-4 mb-6">
        @forelse ($couples as $couple)
            @php
                $testResults = $couple->testResults;
                $avgScore = $testResults->avg('total_score') ?? 0;
                $avgMax = $testResults->avg('max_score') ?? 1;
                $avgPercentage = ($avgScore / $avgMax) * 100;
            @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <!-- Header with JSHSHIR -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-gray-500 mb-1">Foydalanuvchi</div>
                        <div class="font-mono text-sm font-medium text-gray-900 truncate">{{ $couple->jshshir_user }}</div>
                    </div>
                    <div class="ml-3">
                        <span class="px-2 py-1 text-[10px] font-bold rounded-full 
                            @if($avgPercentage >= 80) bg-green-100 text-green-700
                            @elseif($avgPercentage >= 60) bg-blue-100 text-blue-700
                            @elseif($avgPercentage >= 40) bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $avgPercentage >= 80 ? 'Juda yaxshi' : ($avgPercentage >= 60 ? 'Yaxshi' : ($avgPercentage >= 40 ? 'Qisman' : 'Kam mos')) }}
                        </span>
                    </div>
                </div>
                
                <!-- Partner JSHSHIR -->
                <div class="mb-3">
                    <div class="text-xs text-gray-500 mb-1">Jufti</div>
                    <div class="font-mono text-sm text-gray-600 truncate">{{ $couple->jshshir_spouse }}</div>
                </div>
                
                <!-- Results Dropdown -->
                <div class="mb-3">
                    <button type="button" 
                            onclick="toggleDropdown(event, 'dropdown-{{ $couple->id }}')" 
                            class="w-full inline-flex items-center justify-between bg-gray-50 hover:bg-blue-50 border border-gray-200 rounded-lg px-3 py-2 transition-all focus:outline-none">
                        <div class="flex items-center">
                            <div class="text-left">
                                <div class="text-sm font-bold text-gray-900">{{ number_format($avgScore, 1) }} ball</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase">{{ round($avgPercentage) }}% moslik</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
                    </button>
                    
                    <div id="dropdown-{{ $couple->id }}" 
                         class="hidden mt-2 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gray-50 px-3 py-2 border-b border-gray-100">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Batafsil natijalar</h4>
                        </div>
                        <div class="p-3 max-h-60 overflow-y-auto space-y-2">
                            @foreach($testResults as $tIndex => $test)
                                <div class="border-l-2 border-blue-500 pl-2">
                                    <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">Test #{{ $tIndex + 1 }}</p>
                                    @foreach($test->answers->groupBy('question.survey_section_id') as $sectionId => $answers)
                                        @php
                                            $section = $answers->first()->question->surveySection;
                                            $sScore = $answers->sum('score');
                                            $sMax = $answers->count() * 2;
                                        @endphp
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs text-gray-600 truncate" title="{{ $section->title }}">{{ $section->title }}</span>
                                            <span class="text-xs font-semibold bg-gray-100 px-1 py-0.5 rounded text-gray-700">
                                                {{ $sScore }}/{{ $sMax }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                    <div class="text-xs text-gray-400">
                        {{ $couple->created_at->format('d.m.Y') }}
                    </div>
                    <a href="{{ route('admin.couples.show', $couple) }}" 
                       class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        Batafsil <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                <i class="fas fa-inbox text-4xl mb-3 opacity-20 text-gray-400"></i>
                <p class="text-gray-500">Ma'lumotlar topilmadi</p>
            </div>
        @endforelse
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Foydalanuvchi JSHSHIR</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Jufti JSHSHIR</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase text-center">Natijalar</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Holati</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Sana</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Amallar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($couples as $couple)
                        @php
                            $testResults = $couple->testResults;
                            $avgScore = $testResults->avg('total_score') ?? 0;
                            $avgMax = $testResults->avg('max_score') ?? 1;
                            $avgPercentage = ($avgScore / $avgMax) * 100;
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                <span class="font-mono">{{ $couple->jshshir_user }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <span class="font-mono">{{ $couple->jshshir_spouse }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="relative inline-block text-left dropdown-container">
                                    <button type="button" 
                                            onclick="toggleDropdown(event, 'dropdown-{{ $couple->id }}')" 
                                            class="inline-flex items-center gap-x-2 bg-gray-50 hover:bg-blue-50 border border-gray-200 rounded-lg px-3 py-1.5 transition-all focus:outline-none">
                                        <div class="text-left leading-tight">
                                            <div class="text-sm font-bold text-gray-900">{{ number_format($avgScore, 1) }}</div>
                                            <div class="text-[10px] text-gray-400 font-bold uppercase">{{ round($avgPercentage) }}% moslik</div>
                                        </div>
                                        <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
                                    </button>
                                    
                                    <div id="dropdown-{{ $couple->id }}" 
                                         class="hidden absolute z-50 mt-2 w-80 bg-white border border-gray-200 rounded-xl shadow-2xl right-0 overflow-hidden dropdown-menu">
                                        <div class="bg-gray-50 px-4 py-2.5 border-b border-gray-100">
                                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Batafsil natijalar</h4>
                                        </div>
                                        <div class="p-4 max-h-96 overflow-y-auto space-y-4">
                                            @foreach($testResults as $tIndex => $test)
                                                <div class="border-l-2 border-blue-500 pl-3">
                                                    <p class="text-[11px] font-bold text-blue-600 uppercase mb-2">Test #{{ $tIndex + 1 }}</p>
                                                    @foreach($test->answers->groupBy('question.survey_section_id') as $sectionId => $answers)
                                                        @php
                                                            $section = $answers->first()->question->surveySection;
                                                            $sScore = $answers->sum('score');
                                                            $sMax = $answers->count() * 2;
                                                        @endphp
                                                        <div class="flex justify-between items-center mb-1.5 last:mb-0">
                                                            <span class="text-xs text-gray-600 truncate max-w-[160px]" title="{{ $section->title }}">{{ $section->title }}</span>
                                                            <span class="text-xs font-semibold bg-gray-100 px-1.5 py-0.5 rounded text-gray-700">
                                                                {{ $sScore }}/{{ $sMax }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full 
                                    @if($avgPercentage >= 80) bg-green-100 text-green-700
                                    @elseif($avgPercentage >= 60) bg-blue-100 text-blue-700
                                    @elseif($avgPercentage >= 40) bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ $avgPercentage >= 80 ? 'Juda yaxshi' : ($avgPercentage >= 60 ? 'Yaxshi' : ($avgPercentage >= 40 ? 'Qisman' : 'Kam mos')) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                {{ $couple->created_at->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <a href="{{ route('admin.couples.show', $couple) }}" 
                                   class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3 opacity-20"></i>
                                <p>Ma'lumotlar topilmadi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($couples->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Ko'rsatilayotgan <span class="font-medium">{{ $couples->firstItem() }}</span> dan 
                        <span class="font-medium">{{ $couples->lastItem() }}</span> gacha 
                        <span class="font-medium">{{ $couples->total() }}</span> tadan
                    </div>
                    <div class="flex items-center space-x-1">
                        {{-- Previous button --}}
                        @if($couples->onFirstPage())
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-300 rounded-l-md cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $couples->previousPageUrl() }}" 
                               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
                        
                        {{-- Page numbers --}}
                        @for($i = max(1, $couples->currentPage() - 2); $i <= min($couples->lastPage(), $couples->currentPage() + 2); $i++)
                            @if($i == $couples->currentPage())
                                <span aria-current="page" 
                                      class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600">
                                    {{ $i }}
                                </span>
                            @else
                                <a href="{{ $couples->url($i) }}" 
                                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor
                        
                        {{-- Next button --}}
                        @if($couples->hasMorePages())
                            <a href="{{ $couples->nextPageUrl() }}" 
                               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-300 rounded-r-md cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Mobile Pagination -->
    @if($couples->hasPages())
        <div class="lg:hidden mt-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex flex-col items-center space-y-4">
                    <div class="text-sm text-gray-700 text-center">
                        Ko'rsatilayotgan <span class="font-medium">{{ $couples->firstItem() }}</span> dan 
                        <span class="font-medium">{{ $couples->lastItem() }}</span> gacha 
                        <span class="font-medium">{{ $couples->total() }}</span> tadan
                    </div>
                    <div class="flex items-center space-x-1">
                        {{-- Previous button --}}
                        @if($couples->onFirstPage())
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-300 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $couples->previousPageUrl() }}" 
                               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
                        
                        {{-- Page numbers --}}
                        @for($i = max(1, $couples->currentPage() - 1); $i <= min($couples->lastPage(), $couples->currentPage() + 1); $i++)
                            @if($i == $couples->currentPage())
                                <span aria-current="page" 
                                      class="relative z-10 inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg">
                                    {{ $i }}
                                </span>
                            @else
                                <a href="{{ $couples->url($i) }}" 
                                   class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor
                        
                        {{-- Next button --}}
                        @if($couples->hasMorePages())
                            <a href="{{ $couples->nextPageUrl() }}" 
                               class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-300 rounded-lg cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function toggleDropdown(event, id) {
    // Muhim: Tugma bosilganda sahifadagi boshqa click eventlariga xalaqit bermaslik uchun
    event.stopPropagation();
    
    const currentDropdown = document.getElementById(id);
    const allMenus = document.querySelectorAll('.dropdown-menu');

    // Boshqa barcha ochiq dropdownlarni yopish
    allMenus.forEach(menu => {
        if (menu.id !== id) {
            menu.classList.add('hidden');
        }
    });

    // Hozirgisini ochish yoki yopish
    currentDropdown.classList.toggle('hidden');
}

// Sahifaning ixtiyoriy joyi bosilganda dropdownni yopish
document.addEventListener('click', function(event) {
    const allMenus = document.querySelectorAll('.dropdown-menu');
    allMenus.forEach(menu => {
        // Agar bosilgan joy dropdown menyusi bo'lmasa, uni yopamiz
        if (!menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });
});
</script>

<style>
    /* Dropdown paydo bo'lganda boshqa elementlar ustida turishi uchun */
    .dropdown-container { position: relative; }
    .dropdown-menu { 
        top: 100%; 
        right: 0; 
        min-width: 20rem; 
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection