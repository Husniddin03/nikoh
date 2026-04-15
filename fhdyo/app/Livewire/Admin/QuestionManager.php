<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Question;
use App\Models\Unit;
use Livewire\WithPagination;

class QuestionManager extends Component
{
    use WithPagination;

    public string $search = '';
    public int $unitId = 0;
    public ?bool $isCritical = null;
    public array $selectedQuestions = [];
    public string $bulkAction = '';

    protected $paginationTheme = 'tailwind';

    public function mount(): void
    {
        $this->resetFilters();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->unitId = 0;
        $this->isCritical = null;
        $this->selectedQuestions = [];
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedUnitId(): void
    {
        $this->resetPage();
    }

    public function updatedIsCritical(): void
    {
        $this->resetPage();
    }

    public function toggleCritical(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $question->update(['is_critical' => !$question->is_critical]);
        
        $this->dispatch('question-updated', [
            'id' => $questionId,
            'is_critical' => $question->is_critical,
        ]);
    }

    public function deleteQuestion(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        
        if ($question->results()->count() > 0) {
            $this->dispatch('error-message', 'Natijalari bo\'lgan savollarni o\'chirib bo\'lmaydi.');
            return;
        }
        
        $question->delete();
        $this->dispatch('question-deleted', $questionId);
    }

    public function toggleAllSelection(): void
    {
        $questions = $this->getQuestions()->pluck('id')->toArray();
        
        if (count($this->selectedQuestions) === count($questions)) {
            $this->selectedQuestions = [];
        } else {
            $this->selectedQuestions = $questions;
        }
    }

    public function bulkToggleCritical(bool $critical): void
    {
        if (empty($this->selectedQuestions)) {
            $this->dispatch('error-message', 'Iltimos, kamida bitta savolni tanlang.');
            return;
        }

        Question::whereIn('id', $this->selectedQuestions)
            ->update(['is_critical' => $critical]);

        $this->dispatch('bulk-updated', [
            'ids' => $this->selectedQuestions,
            'is_critical' => $critical,
        ]);

        $this->selectedQuestions = [];
    }

    public function bulkDelete(): void
    {
        if (empty($this->selectedQuestions)) {
            $this->dispatch('error-message', 'Iltimos, kamida bitta savolni tanlang.');
            return;
        }

        $questionsWithResults = Question::whereIn('id', $this->selectedQuestions)
            ->whereHas('results')
            ->count();

        if ($questionsWithResults > 0) {
            $this->dispatch('error-message', 'Natijalari bo\'lgan savollarni o\'chirib bo\'lmaydi.');
            return;
        }

        Question::whereIn('id', $this->selectedQuestions)->delete();

        $this->dispatch('bulk-deleted', $this->selectedQuestions);
        $this->selectedQuestions = [];
    }

    public function performBulkAction(): void
    {
        match($this->bulkAction) {
            'mark-critical' => $this->bulkToggleCritical(true),
            'mark-non-critical' => $this->bulkToggleCritical(false),
            'delete' => $this->bulkDelete(),
            default => $this->dispatch('error-message', 'Iltimos, amalni tanlang.'),
        };

        $this->bulkAction = '';
    }

    private function getQuestions()
    {
        $query = Question::with(['unit']);

        // Filter by unit
        if ($this->unitId > 0) {
            $query->where('unit_id', $this->unitId);
        }

        // Filter by critical status
        if ($this->isCritical !== null) {
            $query->where('is_critical', $this->isCritical);
        }

        // Search by question text
        if (!empty($this->search)) {
            $query->where('question', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function getQuestionsProperty()
    {
        return $this->getQuestions()->paginate(20);
    }

    public function getUnitsProperty()
    {
        return Unit::orderBy('category')->orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.admin.question-manager', [
            'questions' => $this->questions,
        ])->layout('layouts.admin', ['title' => 'Savollar']);
    }
}
