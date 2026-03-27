@extends('layouts.app')

@section('title', 'Admin Panel - Juftliklar')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Juftliklar</h1>
            <p class="text-gray-600">Tizimdagi barcha juftliklar ro'yxati</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            SIZNING JSHSHIR
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            JUFTINGIZNING JSHSHIR
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            TEST HOLATI
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            YARATILGAN SANA
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            AMALLAR
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($couples as $couple)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $couple->jshshir_user }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $couple->jshshir_spouse }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($couple->testResults->first())
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $couple->testResults->first()->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $couple->testResults->first()->status == 'completed' ? 'Tugallangan' : 'Jarayonda' }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Test boshlanmagan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $couple->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.couples.show', $couple) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Ko'rish">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-heart text-4xl mb-4"></i>
                                    <p class="text-lg">Juftliklar topilmadi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($couples->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $couples->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
