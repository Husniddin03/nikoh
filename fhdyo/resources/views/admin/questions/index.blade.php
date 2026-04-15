@extends('layouts.admin')

@section('title', 'Savollar')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="flex flex-wrap justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Savollar</h2>
            <p class="text-slate-500 mt-1">Test savollarini boshqarish</p>
        </div>
        <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15"></path>
            </svg>
            Yangi Savol
        </a>
    </div>

    <!-- Search and Filter - Soft UI -->
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6">
        <form method="GET" action="{{ route('admin.questions.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-slate-700 mb-2">Qidirish</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Savol matni..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    >
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Bo'lim</label>
                <select
                    name="unit_id"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[160px]"
                >
                    <option value="">Barchasi</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Muhimlik</label>
                <select
                    name="is_critical"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[140px]"
                >
                    <option value="">Barchasi</option>
                    <option value="1" {{ request('is_critical') === '1' ? 'selected' : '' }}>Muhim</option>
                    <option value="0" {{ request('is_critical') === '0' ? 'selected' : '' }}>Muhim emas</option>
                </select>
            </div>
            <button
                type="submit"
                class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-medium transition-all duration-200"
            >
                Qidirish
            </button>
            @if(request()->has(['search', 'unit_id', 'is_critical']))
                <a href="{{ route('admin.questions.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200">
                    Tozalash
                </a>
            @endif
        </form>
    </div>

    <!-- Bulk Actions - Soft UI -->
    <form id="bulkActions" method="POST" action="{{ route('admin.questions.bulk') }}" class="mb-6">
        @csrf
        <div class="bg-white rounded-2xl p-4 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <div class="flex flex-wrap gap-4 items-center">
                <select
                    name="action"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[200px]"
                    required
                >
                    <option value="">Tanlangan amalni tanlang</option>
                    <option value="critical">Muhim deb belgilash</option>
                    <option value="non_critical">Muhim emas deb belgilash</option>
                    <option value="delete">O'chirish</option>
                </select>
                <button
                    type="submit"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200"
                    onclick="return confirm('Tanlangan amalni bajarishni hohlaysizmi?');"
                >
                    Amalni bajarish
                </button>
            </div>
        </div>
    </form>

    <!-- Questions Table - Soft UI -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-5 sm:px-6 py-4 text-left">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                        </th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Savol</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Bo'lim</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Muhimligi</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Yaratilgan</th>
                        <th class="px-5 sm:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Amallar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($questions as $question)
                        <tr class="hover:bg-slate-50/60 transition-colors duration-200">
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="question_ids[]" value="{{ $question->id }}" class="question-checkbox w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer">
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-sm font-mono font-medium">#{{ $question->id }}</span>
                            </td>
                            <td class="px-5 sm:px-6 py-4">
                                <p class="text-sm text-slate-700 line-clamp-2 max-w-md">{{ $question->question }}</p>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-xs font-medium">
                                    {{ $question->unit->name }}
                                </span>
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                @if($question->is_critical)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold text-rose-700 bg-rose-50 rounded-full">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                        </svg>
                                        Muhim
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-slate-600 bg-slate-100 rounded-full">
                                        Oddiy
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                {{ $question->created_at->format('d.m.Y') }}
                            </td>
                            <td class="px-5 sm:px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.questions.show', $question) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all duration-200" title="Ko'rish">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.questions.edit', $question) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200" title="Tahrirlash">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.questions.toggle-critical', $question) }}" method="POST" class="inline" title="{{ $question->is_critical ? 'Oddiy qilish' : 'Muhim qilish' }}">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                            @if($question->is_critical)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                                </svg>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST" class="inline" onsubmit="return confirm('Savolni o\'chirishni hohlaysizmi?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all duration-200" title="O'chirish">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Savollar topilmadi</p>
                                <p class="text-sm text-slate-400 mt-1">Yangi savol qo'shish uchun yuqoridagi tugmani bosing</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($questions->hasPages())
        <div class="mt-6">
            {{ $questions->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const questionCheckboxes = document.querySelectorAll('.question-checkbox');
            const bulkActionsForm = document.getElementById('bulkActions');

            // Select all functionality
            selectAllCheckbox.addEventListener('change', function() {
                questionCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Update select all when individual checkboxes change
            questionCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(questionCheckboxes).every(cb => cb.checked);
                    const someChecked = Array.from(questionCheckboxes).some(cb => cb.checked);
                    
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                });
            });

            // Add selected question IDs to form
            bulkActionsForm.addEventListener('submit', function(e) {
                const selectedQuestions = [];
                questionCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedQuestions.push(checkbox.value);
                    }
                });

                if (selectedQuestions.length === 0) {
                    e.preventDefault();
                    alert('Iltimos, kamida bitta savolni tanlang.');
                    return;
                }
            });
        });
    </script>
@endsection
