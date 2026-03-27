@extends('layouts.app')

@section('title', 'Admin Panel - Test natijalari')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Test natijalari</h1>
            <p class="text-gray-600">Barcha tugallangan test natijalari</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TEST ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            JSHSHIR (Siz)
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            JSHSHIR (Juft)
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            JAMI BALL
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            MOSLISH DARAJASI
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TUGATILGAN VAQT
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            AMALLAR
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($testResults as $testResult)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                #{{ $testResult->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $testResult->couple->jshshir_user }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $testResult->couple->jshshir_spouse }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $testResult->total_score }} / {{ $testResult->max_score }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $testResult->compatibility_level == 'Juda mos' ? 'bg-green-100 text-green-800' : 
                                       ($testResult->compatibility_level == 'Yaxshi mos' ? 'bg-blue-100 text-blue-800' :
                                       ($testResult->compatibility_level == 'Oʻrtacha mos' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-red-100 text-red-800')) }}">
                                    {{ $testResult->compatibility_level }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $testResult->completed_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('survey.result', $testResult) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Batafsil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.couples.show', $testResult->couple) }}" 
                                       class="text-green-600 hover:text-green-900" title="Juftlik">
                                        <i class="fas fa-heart"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-chart-line text-4xl mb-4"></i>
                                    <p class="text-lg">Test natijalari topilmadi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($testResults->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $testResults->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
