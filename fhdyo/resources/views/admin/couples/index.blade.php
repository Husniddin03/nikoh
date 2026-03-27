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
                
                <!-- Results Display -->
                <div class="mb-3">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                        <div class="flex items-center justify-between">
                            <div class="text-left">
                                <div class="text-sm font-bold text-gray-900">{{ number_format($avgScore, 1) }} ball</div>
                                <div class="text-[10px] text-gray-400 font-bold uppercase">{{ round($avgPercentage) }}% moslik</div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-[10px] font-bold rounded-full 
                                    @if($avgPercentage >= 80) bg-green-100 text-green-700
                                    @elseif($avgPercentage >= 60) bg-blue-100 text-blue-700
                                    @elseif($avgPercentage >= 40) bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ $avgPercentage >= 80 ? 'Juda yaxshi' : ($avgPercentage >= 60 ? 'Yaxshi' : ($avgPercentage >= 40 ? 'Qisman' : 'Kam mos')) }}
                                </span>
                            </div>
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
    <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-100 overflow-visible">
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
    <div class="text-sm font-bold text-gray-900">{{ number_format($avgScore, 1) }}</div>
    <div class="text-[10px] text-gray-400 font-bold uppercase">{{ round($avgPercentage) }}% moslik</div>
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

@endsection