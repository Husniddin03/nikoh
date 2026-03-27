<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurveySection;
use App\Models\Question;

class UnitController extends Controller
{
    public function index()
    {
        $units = SurveySection::withCount('activeQuestions')
            ->orderBy('order')
            ->get();

        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('admin.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        SurveySection::create([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit muvaffaqiyatli qo\'shildi');
    }

    public function edit(SurveySection $unit)
    {
        $unit->load('activeQuestions');
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, SurveySection $unit)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $unit->update([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit muvaffaqiyatli yangilandi');
    }

    public function destroy(SurveySection $unit)
    {
        // Check if unit has questions
        if ($unit->questions()->exists()) {
            return back()->with('error', 'Bu unitda savollar mavjud. Avval savollarni o\'chirib tashlang.');
        }

        $unit->delete();

        return redirect()->route('admin.units.index')
            ->with('success', 'Unit muvaffaqiyatli o\'chirildi');
    }

    // Questions management
    public function createQuestion(SurveySection $unit)
    {
        return view('admin.units.questions.create', compact('unit'));
    }

    public function storeQuestion(Request $request, SurveySection $unit)
    {
        $request->validate([
            'question_text' => 'required|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        Question::create([
            'survey_section_id' => $unit->id,
            'question_text' => $request->question_text,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.units.edit', $unit)
            ->with('success', 'Savol muvaffaqiyatli qo\'shildi');
    }

    public function editQuestion(SurveySection $unit, Question $question)
    {
        return view('admin.units.questions.edit', compact('unit', 'question'));
    }

    public function updateQuestion(Request $request, SurveySection $unit, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'order' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $question->update([
            'question_text' => $request->question_text,
            'order' => $request->order,
            'is_active' => $request->boolean('is_active', true)
        ]);

        return redirect()->route('admin.units.edit', $unit)
            ->with('success', 'Savol muvaffaqiyatli yangilandi');
    }

    public function destroyQuestion(SurveySection $unit, Question $question)
    {
        $question->delete();

        return redirect()->route('admin.units.edit', $unit)
            ->with('success', 'Savol muvaffaqiyatli o\'chirildi');
    }
}
