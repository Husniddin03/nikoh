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

        // Check if this couple already exists
        $existingCouple = Couple::where('jshshir_user', $request->jshshir)
            ->where('jshshir_spouse', $request->partner_jshshir)
            ->first();

        if ($existingCouple) {
            // Check if there's an incomplete test
            $incompleteTest = $existingCouple->testResults()
                ->where('status', 'in_progress')
                ->first();

            if ($incompleteTest) {
                return redirect()->route('survey.take', ['testResult' => $incompleteTest->id])
                    ->with('info', 'Sizning tugatmagan testingiz bor. Davom ettirish uchun pastga o\'ting.');
            }

            // Check if there's a completed test
            $completedTest = $existingCouple->testResults()
                ->where('status', 'completed')
                ->first();

            if ($completedTest) {
                return redirect()->route('survey.result', ['testResult' => $completedTest->id])
                    ->with('info', 'Bu juftlik allaqachon testni tugatgan. Natijalarni ko\'rish uchun pastga o\'ting.');
            }
        }

        // Create new couple
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
        $sections = SurveySection::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // For each section, get 5 random questions
        $sectionsWithRandomQuestions = $sections->map(function($section) {
            $randomQuestions = Question::where('survey_section_id', $section->id)
                ->where('is_active', true)
                ->inRandomOrder()
                ->take(5)
                ->get();
            
            $section->setRelation('activeQuestions', $randomQuestions);
            return $section;
        });

        return view('survey.take', [
            'testResult' => $testResult, 
            'sections' => $sectionsWithRandomQuestions
        ]);
    }

    public function resetTest(TestResult $testResult)
    {
        // Only allow reset if test is completed
        if ($testResult->status !== 'completed') {
            return back()->with('error', 'Faqat tugallangan testni qayta boshlash mumkin.');
        }

        // Delete existing answers
        Answer::where('test_result_id', $testResult->id)->delete();

        // Reset test result
        $testResult->update([
            'total_score' => 0,
            'section_scores' => [],
            'status' => 'in_progress',
            'completed_at' => null,
            'compatibility_level' => ''
        ]);

        return redirect()->route('survey.take', ['testResult' => $testResult->id])
            ->with('info', 'Test qayta boshlandi. Yangi savollar tanlandi.');
    }

    public function submit(Request $request, TestResult $testResult)
    {
        // Check if test is already completed
        if ($testResult->status === 'completed') {
            return back()->with('error', 'Bu test allaqachon tugatilgan.');
        }

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
                
                // Calculate score based on answer
                $score = $answer === 'yes' ? 2 : ($answer === 'partially' ? 1 : 0);
                $totalScore += $score;

                // Store answer
                Answer::create([
                    'test_result_id' => $testResult->id,
                    'question_id' => $questionId,
                    'answer' => $answer,
                    'score' => $score
                ]);

                // Calculate section scores
                $sectionId = $question->survey_section_id;
                if (!isset($sectionScores[$sectionId])) {
                    $sectionScores[$sectionId] = 0;
                }
                $sectionScores[$sectionId] += $score;
            }

            // Update test result
            $testResult->update([
                'total_score' => $totalScore,
                'section_scores' => $sectionScores,
                'status' => 'completed',
                'completed_at' => now()
            ]);

            // Calculate compatibility level
            $percentage = ($totalScore / $testResult->max_score) * 100;
            $compatibilityLevel = $this->calculateCompatibilityLevel($percentage);
            
            $testResult->update([
                'compatibility_level' => $compatibilityLevel
            ]);

            // Check if partner has a completed test and calculate comparison
            $partnerTest = $this->findPartnerTest($testResult);
            if ($partnerTest) {
                $this->calculateAndStoreComparison($testResult, $partnerTest);
            }

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

        // Get partner test for comparison
        $partnerTest = $this->findPartnerTest($testResult);
        $comparison = null;
        if ($partnerTest) {
            $comparison = $this->calculateComparison($testResult, $partnerTest);
        }

        return view('survey.result', compact('testResult', 'sectionScores', 'partnerTest', 'comparison'));
    }

    private function findPartnerTest(TestResult $testResult)
    {
        $couple = $testResult->couple;
        
        // Find test where either person is the spouse of the other
        return TestResult::whereHas('couple', function($query) use ($couple) {
            $query->where(function($q) use ($couple) {
                // Case 1: current person is user, find where they are spouse
                $q->where('jshshir_user', $couple->jshshir_spouse)
                  ->where('jshshir_spouse', $couple->jshshir_user);
                // Case 2: current person is spouse, find where they are user  
                $q->orWhere('jshshir_user', $couple->jshshir_user)
                  ->where('jshshir_spouse', $couple->jshshir_spouse);
            });
        })
        ->where('status', 'completed')
        ->where('id', '!=', $testResult->id) // Exclude current test
        ->first();
    }

    private function calculateCompatibilityLevel($percentage)
    {
        if ($percentage >= 80) return 'Juda yaxshi mos keladi';
        if ($percentage >= 60) return 'Yaxshi mos keladi';
        if ($percentage >= 40) return 'Qisman mos keladi';
        if ($percentage >= 20) return 'Kam mos keladi';
        return 'Jiddiy mos kelmaslik';
    }

    private function calculateAndStoreComparison(TestResult $test1, TestResult $test2)
    {
        $comparison = $this->calculateComparison($test1, $test2);
        
        // Store comparison in session or database as needed
        session(['partner_comparison' => $comparison]);
    }

    private function calculateComparison(TestResult $test1, TestResult $test2)
    {
        $scoreDiff = abs($test1->total_score - $test2->total_score);
        $avgScore = ($test1->total_score + $test2->total_score) / 2;
        
        return [
            'person1_score' => $test1->total_score,
            'person2_score' => $test2->total_score,
            'score_difference' => $scoreDiff,
            'average_score' => $avgScore,
            'compatibility_rating' => $scoreDiff <= 5 ? 'Juda yuqori moslik' : 
                                   ($scoreDiff <= 10 ? 'Yuqori moslik' : 
                                   ($scoreDiff <= 15 ? 'O\'rtacha moslik' : 'Past moslik')),
            'recommendation' => $scoreDiff <= 5 ? 'Sizning juftingiz bilan juda yaxshi mos kelyapsiz!' :
                             ($scoreDiff <= 10 ? 'Sizning juftingiz bilan yaxshi mos kelyapsi!' :
                             ($scoreDiff <= 15 ? 'Sizning juftingiz bilan o\'rtacha mos kelyapsi.' : 
                             'Sizning juftingiz bilan moslik past, ammo bu faqat test natijasi.'))
        ];
    }
}
