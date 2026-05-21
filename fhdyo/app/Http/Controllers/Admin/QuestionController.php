<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Unit;
use App\Http\Requests\Admin\QuestionRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function __construct()
    {
        // Placeholder for admin authentication middleware
        // $this->middleware('auth:admin');
    }

    /**
     * Display a listing of questions
     */
    public function index(Request $request): View
    {
        $query = Question::with(['unit', 'admin']);

        // Filter by unit
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // Filter by critical status
        if ($request->filled('is_critical')) {
            $query->where('is_critical', $request->boolean('is_critical'));
        }

        // Search by question text
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('question', 'like', "%{$search}%");
        }

        $questions = $query->orderBy('unit_id')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $units = Unit::orderBy('category')->orderBy('name')->get();

        return view('admin.questions.index', compact('questions', 'units'));
    }

    /**
     * Show the form for creating a new question
     */
    public function create(): View
    {
        $units = Unit::orderBy('category')->orderBy('name')->get();
        
        return view('admin.questions.create', compact('units'));
    }

    /**
     * Store a newly created question
     */
    public function store(QuestionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['admin_id'] = 1; // Placeholder - get from authenticated admin

        Question::create($data);

        return redirect()
            ->route('admin.questions.create')
            ->with('success', 'Savol muvaffaqiyatli yaratildi.');
    }

    /**
     * Display the specified question
     */
    public function show(Question $question): View
    {
        $question->load(['unit', 'admin', 'results' => function($query) {
            $query->selectRaw('question_id, COUNT(*) as total_answers, AVG(CASE WHEN answer = 1 THEN 1 ELSE 0 END) as agreement_rate')
                ->groupBy('question_id');
        }]);

        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question
     */
    public function edit(Question $question): View
    {
        $units = Unit::orderBy('category')->orderBy('name')->get();
        
        return view('admin.questions.edit', compact('question', 'units'));
    }

    /**
     * Update the specified question
     */
    public function update(QuestionRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Savol muvaffaqiyatli yangilandi.');
    }

    /**
     * Remove the specified question
     */
    public function destroy(Question $question): RedirectResponse
    {
        // Check if question has results
        if ($question->results()->count() > 0) {
            return redirect()
                ->route('admin.questions.index')
                ->with('error', 'Savolni o\'chirish uchun avval uning natijalarini o\'chirishingiz kerak.');
        }

        $question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Savol muvaffaqiyatli o\'chirildi.');
    }

    /**
     * Toggle critical status of a question
     */
    public function toggleCritical(Question $question): RedirectResponse
    {
        $question->update(['is_critical' => !$question->is_critical]);

        $status = $question->is_critical ? 'muhim' : 'muhim emas';
        
        return redirect()
            ->route('admin.questions.index')
            ->with('success', "Savol muhimligi holati '{$status}' deb belgilandi.");
    }

    /**
     * Bulk actions for questions
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:delete,critical,non_critical',
            'question_ids' => 'required|array',
            'question_ids.*' => 'exists:questions,id',
        ]);

        $questionIds = $request->input('question_ids');
        $action = $request->input('action');

        switch ($action) {
            case 'delete':
                // Check for results before deleting
                $questionsWithResults = Question::whereIn('id', $questionIds)
                    ->whereHas('results')
                    ->count();
                
                if ($questionsWithResults > 0) {
                    return redirect()
                        ->route('admin.questions.index')
                        ->with('error', 'Natijalari bo\'lgan savollarni o\'chirib bo\'lmaydi.');
                }
                
                Question::whereIn('id', $questionIds)->delete();
                $message = 'Tanlangan savollar o\'chirildi.';
                break;

            case 'critical':
                Question::whereIn('id', $questionIds)->update(['is_critical' => true]);
                $message = 'Tanlangan savollar muhim deb belgilandi.';
                break;

            case 'non_critical':
                Question::whereIn('id', $questionIds)->update(['is_critical' => false]);
                $message = 'Tanlangan savollar muhim emas deb belgilandi.';
                break;
        }

        return redirect()
            ->route('admin.questions.index')
            ->with('success', $message);
    }

    /**
     * Get questions by unit (AJAX endpoint)
     */
    public function getByUnit(Request $request)
    {
        $unitId = $request->input('unit_id');
        
        $questions = Question::where('unit_id', $unitId)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'question', 'is_critical']);

        return response()->json($questions);
    }

    /**
     * Duplicate a question
     */
    public function duplicate(Question $question): RedirectResponse
    {
        $newQuestion = $question->replicate();
        $newQuestion->question = $question->question . ' (Nusxa)';
        $newQuestion->admin_id = 1; // Placeholder - get from authenticated admin
        $newQuestion->save();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Savol muvaffaqiyatli nusxalandi.');
    }
}
