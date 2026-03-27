@extends('layouts.app')

@section('title', 'Admin Panel - Juftlik tafsilotlari')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.couples') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Juftlik tafsilotlari</h1>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sizning JSHSHIR</h3>
                    <p class="text-2xl font-mono text-blue-600">{{ $couple->jshshir_user }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Juftingizning JSHSHIR</h3>
                    <p class="text-2xl font-mono text-pink-600">{{ $couple->jshshir_spouse }}</p>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <p>Yaratilgan vaqt: {{ $couple->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Test natijalari</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TEST ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            HOLAT
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            JAMI BALL
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            MOSLISH DARAJASI
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            BOSHLANGAN
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TUGATILGAN
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $testResult->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $testResult->status == 'completed' ? 'Tugallangan' : 'Jarayonda' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $testResult->total_score }} / {{ $testResult->max_score }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $testResult->compatibility_level }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $testResult->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $testResult->completed_at?->format('Y-m-d H:i') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @if($testResult->status == 'completed')
                                        <a href="{{ route('survey.result', $testResult) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="Natijani ko'rish">
                                            <i class="fas fa-chart-bar"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-clipboard-list text-4xl mb-4"></i>
                                    <p class="text-lg">Test natijalari topilmadi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
