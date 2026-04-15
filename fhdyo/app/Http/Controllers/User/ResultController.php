<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TestSession;
use App\Models\User;
use App\Services\CompatibilityService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use App\Models\Result;
use App\Models\Question;

class ResultController extends Controller
{
    protected CompatibilityService $compatibilityService;

    public function __construct(CompatibilityService $compatibilityService)
    {
        $this->compatibilityService = $compatibilityService;
    }

    /**
     * Display the test results for a specific session
     */
    public function index(TestSession $session): View|Response
    {
        // Security check: ensure user can only access their own sessions
        $currentUser = $this->getCurrentUser();
        
        if (!$currentUser) {
            abort(403, 'Iltimos, avval testni boshlang.');
        }
        
        if ($session->initiator_id !== $currentUser->id && $session->partner_id !== $currentUser->id) {
            abort(403, 'Siz bu natijalarni ko\'rish huquqiga ega emassiz.');
        }

        // Ensure session is completed
        if ($session->status !== 'completed') {
            abort(403, 'Test hali tugallanmagan.');
        }

        // Get unit scores with relationships
        $unitScores = $session->unitScores()
            ->with('unit')
            ->get();
        
        // If no scores exist yet, calculate them
        if ($unitScores->isEmpty()) {
            $this->compatibilityService->calculate($session);
            $unitScores = $session->unitScores()
                ->with('unit')
                ->get();
        }

        // Prepare chart data
        $chartData = $this->prepareChartData($unitScores);
        
        // Calculate overall compatibility
        $overallCompatibility = $this->compatibilityService->getOverallCompatibility($session);
        
        // Generate recommendations for low-scoring units
        $recommendations = $this->generateRecommendations($unitScores);

        // Get partner information
        $partner = $session->initiator_id === $currentUser->id 
            ? $session->partner 
            : $session->initiator;

        // Get detailed answers comparison
        $answersComparison = $this->getAnswersComparison($session, $currentUser, $partner);

        return view('user.results', compact(
            'session',
            'unitScores',
            'chartData',
            'overallCompatibility',
            'recommendations',
            'partner',
            'currentUser',
            'answersComparison'
        ));
    }

    /**
     * Download test results as PDF
     */
    public function downloadPdf(TestSession $session): Response
    {
        // Security check
        $currentUser = $this->getCurrentUser();
        
        if (!$currentUser) {
            abort(403, 'Iltimos, avval testni boshlang.');
        }
        
        if ($session->initiator_id !== $currentUser->id && $session->partner_id !== $currentUser->id) {
            abort(403, 'Siz bu natijalarni yuklab olish huquqiga ega emassiz.');
        }

        if ($session->status !== 'completed') {
            abort(403, 'Test hali tugallanmagan.');
        }

        // Get data
        $unitScores = $session->unitScores()->with('unit')->get();
        
        if ($unitScores->isEmpty()) {
            $this->compatibilityService->calculate($session);
            $unitScores = $session->unitScores()->with('unit')->get();
        }

        $overallCompatibility = $this->compatibilityService->getOverallCompatibility($session);
        $partner = $session->initiator_id === $currentUser->id 
            ? $session->partner 
            : $session->initiator;

        // Get detailed answers comparison for PDF
        $answersComparison = $this->getAnswersComparison($session, $currentUser, $partner);

        // Generate PDF
        $pdf = Pdf::loadView('user.results-pdf', compact(
            'session',
            'unitScores',
            'overallCompatibility',
            'partner',
            'currentUser',
            'answersComparison'
        ));

        // Set PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isRemoteEnabled' => false,
            'isHtml5ParserEnabled' => true,
        ]);

        $fileName = 'nikoh_test_natijalari_' . $session->id . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Prepare data for charts (radar/bar chart)
     */
    private function prepareChartData($unitScores): array
    {
        $labels = [];
        $data = [];
        $backgroundColor = [];
        $borderColor = [];

        foreach ($unitScores as $score) {
            $labels[] = $score->unit->name;
            $data[] = round($score->match_percentage, 1);
            
            // Color coding based on score
            if ($score->match_percentage >= 75) {
                $backgroundColor[] = 'rgba(34, 197, 94, 0.2)'; // green
                $borderColor[] = 'rgba(34, 197, 94, 1)';
            } elseif ($score->match_percentage >= 50) {
                $backgroundColor[] = 'rgba(251, 191, 36, 0.2)'; // yellow
                $borderColor[] = 'rgba(251, 191, 36, 1)';
            } else {
                $backgroundColor[] = 'rgba(239, 68, 68, 0.2)'; // red
                $borderColor[] = 'rgba(239, 68, 68, 1)';
            }
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Muvofiqlik foizi',
                    'data' => $data,
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $borderColor,
                    'borderWidth' => 2,
                ]
            ]
        ];
    }

    /**
     * Generate recommendations for low-scoring units
     */
    private function generateRecommendations($unitScores): array
    {
        $recommendations = [];

        foreach ($unitScores as $score) {
            if ($score->match_percentage < 50) {
                $recommendations[] = [
                    'unit_name' => $score->unit->name,
                    'score' => round($score->match_percentage, 1),
                    'recommendation' => $this->getRecommendationText($score->unit->category, $score->match_percentage)
                ];
            }
        }

        return $recommendations;
    }

    /**
     * Get recommendation text based on unit category and score
     */
    private function getRecommendationText(string $category, float $score): string
    {
        if ($category === 'nikoh') {
            if ($score < 30) {
                return "Oilaviy hayot haqida chuqur suhbatlashish tavsiya etiladi. Nikohdan oldin muhim masalalarda kelishuvga erishish muhim.";
            } else {
                return "Oilaviy hayotga oid ko'proq masalalarni muhokama qiling. O'zaro tushunishni mustahkamlashingiz kerak.";
            }
        } elseif ($category === 'ajrim') {
            if ($score < 30) {
                return "Ajrim masalalari bo'yicha jiddiy kelishmovchiliklar bor. Maslahat olish yoki professional yordam ko'rsatish tavsiya etiladi.";
            } else {
                return "Ajrim masalalari bo'yicha fikrlaringiz farq qiladi. Bu masalani ehtiyotkorlik bilan ko'rib chiqing.";
            }
        }

        return "Bu sohada ko'proq suhbatlashishingiz va o'zaro tushunishni mustahkamlashingiz kerak.";
    }

    /**
     * Get current user based on session JSHSHIR
     */
    private function getCurrentUser(): ?User
    {
        $userJshshir = session('user_jshshir');
        
        if ($userJshshir) {
            return User::where('jshshir', $userJshshir)->first();
        }
        
        return null;
    }

    /**
     * Get detailed answers comparison between two users
     */
    private function getAnswersComparison(TestSession $session, User $currentUser, User $partner): array
    {
        $comparison = [];
        
        // Get all results for this session
        $allResults = Result::where('session_id', $session->id)
            ->with('question.unit')
            ->get();
        
        // Get questions
        $questions = Question::whereIn('id', $session->question_ids ?? [])
            ->with('unit')
            ->get()
            ->keyBy('id');
        
        // Group results by question
        $resultsByQuestion = $allResults->groupBy('question_id');
        
        foreach ($resultsByQuestion as $questionId => $questionResults) {
            $question = $questions->get($questionId);
            if (!$question) continue;
            
            $userAnswer = $questionResults->firstWhere('user_id', $currentUser->id);
            $partnerAnswer = $questionResults->firstWhere('user_id', $partner->id);
            
            // Only include if both answered
            if ($userAnswer && $partnerAnswer) {
                $isMatch = $userAnswer->answer === $partnerAnswer->answer;
                
                $comparison[] = [
                    'question_id' => $questionId,
                    'question' => $question->question,
                    'unit_name' => $question->unit->name ?? 'Noma\'lum',
                    'is_critical' => $question->is_critical,
                    'user_answer' => $userAnswer->answer,
                    'partner_answer' => $partnerAnswer->answer,
                    'is_match' => $isMatch,
                    'agreement_text' => $isMatch ? 'Mos keldi' : 'Zid keldi',
                ];
            }
        }
        
        // Sort by match status (mismatches first) and then by critical questions
        usort($comparison, function ($a, $b) {
            if ($a['is_match'] !== $b['is_match']) {
                return $a['is_match'] ? 1 : -1; // Mismatches first
            }
            if ($a['is_critical'] !== $b['is_critical']) {
                return $b['is_critical'] ? 1 : -1; // Critical questions first
            }
            return 0;
        });
        
        return $comparison;
    }
}
