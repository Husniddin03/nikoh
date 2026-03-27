<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveySection;
use App\Models\Question;
use App\Models\TestResult;
use App\Models\Answer;
use App\Models\Couple;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.start');
    }

    public function start(Request $request)
    {
        $request->validate([
            'jshshir' => 'required|digits:14',
            'partner_jshshir' => 'required|digits:14|different:jshshir'
        ]);

        $couple = Couple::create([
            'jshshir_user' => $request->jshshir,
            'jshshir_spouse' => $request->partner_jshshir,
        ]);

        $testResult = TestResult::create([
            'couple_id' => $couple->id,
            'total_score' => 0,
            'max_score' => 50, // 5 sections * 5 questions * 2 points max
            'compatibility_level' => '',
            'section_scores' => [],
            'status' => 'in_progress'
        ]);

        return redirect()->route('survey.take', ['testResult' => $testResult->id]);
    }

    public function take(TestResult $testResult)
    {
        $sections = SurveySection::with(['activeQuestions' => function($query) {
            $query->take(5);
        }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('survey.take', compact('testResult', 'sections'));
    }

    public function submit(Request $request, TestResult $testResult)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|in:yes,partially,no'
        ]);

        DB::beginTransaction();
        try {
            $totalScore = 0;
            $sectionScores = [];

            foreach ($request->answers as $questionId => $answer) {
                $question = Question::findOrFail($questionId);
                $score = Answer::getScoreFromAnswer($answer);

                Answer::create([
                    'test_result_id' => $testResult->id,
                    'question_id' => $questionId,
                    'score' => $score,
                    'answer' => $answer
                ]);

                $sectionId = $question->survey_section_id;
                if (!isset($sectionScores[$sectionId])) {
                    $sectionScores[$sectionId] = 0;
                }
                $sectionScores[$sectionId] += $score;
                $totalScore += $score;
            }

            $testResult->update([
                'total_score' => $totalScore,
                'compatibility_level' => $testResult->calculateCompatibilityLevel(),
                'section_scores' => $sectionScores,
                'status' => 'completed',
                'completed_at' => now()
            ]);

            DB::commit();
            return redirect()->route('survey.result', ['testResult' => $testResult->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Testni saqlashda xatolik yuz berdi.']);
        }
    }

    public function result(TestResult $testResult)
    {
        $testResult->load(['couple', 'answers.question.surveySection']);
        
        $sections = SurveySection::with(['activeQuestions' => function($query) {
            $query->take(5);
        }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $sectionScores = [];
        foreach ($testResult->answers as $answer) {
            $sectionId = $answer->question->survey_section_id;
            if (!isset($sectionScores[$sectionId])) {
                $sectionScores[$sectionId] = [
                    'section' => $answer->question->surveySection,
                    'score' => 0,
                    'max_score' => 0
                ];
            }
            $sectionScores[$sectionId]['score'] += $answer->score;
            $sectionScores[$sectionId]['max_score'] += 2;
        }

        return view('survey.result', compact('testResult', 'sectionScores'));
    }
}
