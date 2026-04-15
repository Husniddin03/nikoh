<div class="max-w-7xl mx-auto">
    <!-- Page Header - Soft UI -->
    <div class="flex flex-wrap justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900">Savollar</h2>
            <p class="text-slate-500 mt-1">Test savollarini boshqarish (Livewire)</p>
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
        <div class="flex flex-wrap gap-4 items-end">
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
                        wire:model.live.debounce.300ms="search"
                        placeholder="Savol matni..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all"
                    >
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Bo'lim</label>
                <select
                    wire:model.live="unitId"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[180px]"
                >
                    <option value="0">Barchasi</option>
                    @foreach($this->units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->category === 'nikoh' ? 'Nikoh' : 'Ajrim' }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Muhimlik</label>
                <select
                    wire:model.live="isCritical"
                    class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[140px]"
                >
                    <option value="">Barchasi</option>
                    <option value="1">Muhim</option>
                    <option value="0">Muhim emas</option>
                </select>
            </div>
            <button
                wire:click="resetFilters"
                class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-medium transition-all duration-200"
            >
                Tozalash
            </button>
        </div>
    </div>

    <!-- Bulk Actions - Soft UI -->
    <div class="bg-white rounded-2xl p-4 shadow-[0_8px_30px_rgb(0,0,0,0.04)] mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <select
                wire:model="bulkAction"
                class="px-4 py-2.5 bg-slate-50 border-0 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white cursor-pointer transition-all min-w-[220px]"
            >
                <option value="">Tanlangan amalni tanlang</option>
                <option value="mark-critical">Muhim deb belgilash</option>
                <option value="mark-non-critical">Muhim emas deb belgilash</option>
                <option value="delete">O'chirish</option>
            </select>
            <button
                wire:click="performBulkAction"
                wire:loading.attr="disabled"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-medium transition-all duration-200 shadow-lg shadow-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2"
            >
                <span wire:loading.remove>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"></path>
                    </svg>
                    Amalni bajarish
                </span>
                <span wire:loading>
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Bajarilmoqda...
                </span>
            </button>
        </div>
    </div>

    <!-- Questions Table - Soft UI -->
    <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-5 sm:px-6 py-4 text-left">
                            <input
                                type="checkbox"
                                wire:model.live="selectAll"
                                class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer"
                            >
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
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedQuestions"
                                    value="{{ $question->id }}"
                                    class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 cursor-pointer"
                                >
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
                                <button
                                    wire:click="toggleCritical({{ $question->id }})"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-full transition-all duration-200 {{ $question->is_critical ? 'bg-rose-50 text-rose-700 hover:bg-rose-100' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                                >
                                    @if($question->is_critical)
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path>
                                        </svg>
                                        Muhim
                                    @else
                                        Oddiy
                                    @endif
                                </button>
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
                                    <button
                                        wire:click="deleteQuestion({{ $question->id }})"
                                        wire:loading.attr="disabled"
                                        wire:confirm="Savolni o'chirishni hohlaysizmi?"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all duration-200 disabled:opacity-50"
                                        title="O'chirish"
                                    >
                                        <span wire:loading.remove>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                            </svg>
                                        </span>
                                        <span wire:loading>
                                            <svg class="animate-spin h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        </span>
                                    </button>
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
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $questions->links() }}
    </div>
</div>

<!-- Event Listeners for real-time updates -->
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('question-updated', (data) => {
            // Show success message
            const message = `Savol ${data.is_critical ? 'muhim' : 'muhim emas'} deb belgilandi.`;
            // You can implement a toast notification here
            console.log(message);
        });

        Livewire.on('question-deleted', (id) => {
            // Show success message
            console.log('Savol o\'chirildi:', id);
        });

        Livewire.on('error-message', (message) => {
            // Show error message
            console.error('Xatolik:', message);
        });
    });
</script>
