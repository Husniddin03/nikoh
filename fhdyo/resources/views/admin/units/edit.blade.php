@extends('layouts.app')

@section('title', 'Admin Panel - Unit tahrirlash')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.units.index') }}" class="text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left"></i> Orqaga
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Unit tahrirlash: {{ $unit->title }}</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Unit Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <form action="{{ route('admin.units.update', $unit) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800">Unit ma'lumotlari</h3>
                        
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Unit nomi
                            </label>
                            <input type="text" id="title" name="title" required
                                   value="{{ old('title', $unit->title) }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Tavsif
                            </label>
                            <textarea id="description" name="description" rows="3"
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('description', $unit->description) }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">
                                    Tartib raqami
                                </label>
                                <input type="number" id="order" name="order" required min="1"
                                       value="{{ old('order', $unit->order) }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $unit->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Faol
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 pt-4 border-t border-gray-200">
                            <button type="submit" 
                                    class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-sm">
                                Saqlash
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Questions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-800">Savollar</h3>
                        <a href="{{ route('admin.units.questions.create', $unit) }}" 
                           class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-sm">
                            <i class="fas fa-plus mr-1"></i> Savol qo'shish
                        </a>
                    </div>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @forelse ($unit->activeQuestions as $question)
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="text-sm text-gray-500 mb-2">Savol #{{ $question->order }}</div>
                                    <div class="text-gray-900">{{ $question->question_text }}</div>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $question->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $question->is_active ? 'Faol' : 'Nofaol' }}
                                    </span>
                                    <a href="{{ route('admin.units.questions.edit', [$unit, $question]) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Tahrirlash">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.units.questions.destroy', [$unit, $question]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Ushbu savolni o\'chirishni istaysizmi?')"
                                                class="text-red-600 hover:text-red-900" title="O'chirish">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-question-circle text-4xl mb-4"></i>
                                <p class="text-lg">Savollar topilmadi</p>
                                <a href="{{ route('admin.units.questions.create', $unit) }}" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    <i class="fas fa-plus mr-2"></i> Birinchi savolni qo'shish
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
