<?php

namespace App\Services;

use App\Models\TestSession;
use App\Models\Result;
use App\Models\Question;
use App\Models\UnitScore;
use Illuminate\Support\Collection;

class CompatibilityService
{
    /**
     * Calculate compatibility scores for a test session
     */
    public function calculate(TestSession $session): void
    {
        // Get all results for this session grouped by question
        $results = Result::where('session_id', $session->id)
            ->with('question.unit')
            ->get()
            ->groupBy('question_id');

        // Group questions by unit
        $questionsByUnit = Question::whereIn('id', $session->question_ids)
            ->with('unit')
            ->get()
            ->groupBy('unit_id');

        // Calculate scores for each unit
        foreach ($questionsByUnit as $unitId => $questions) {
            $this->calculateUnitScore($session, $unitId, $questions, $results);
        }

        // Update session status to completed
        $session->update(['status' => 'completed']);
    }

    /**
     * Calculate compatibility score for a specific unit
     */
    private function calculateUnitScore(
        TestSession $session, 
        int $unitId, 
        Collection $questions, 
        Collection $results
    ): void {
        $totalQuestions = $questions->count();
        $matches = 0;
        $criticalDisagreements = 0;

        foreach ($questions as $question) {
            $questionResults = $results->get($question->id);
            
            if (!$questionResults || $questionResults->count() < 2) {
                continue;
            }

            // Get answers from both users
            $initiatorAnswer = $questionResults
                ->where('user_id', $session->initiator_id)
                ->first()?->answer;

            $partnerAnswer = $questionResults
                ->where('user_id', $session->partner_id)
                ->first()?->answer;

            // Check if both answers exist
            if ($initiatorAnswer !== null && $partnerAnswer !== null) {
                if ($initiatorAnswer === $partnerAnswer) {
                    $matches++;
                } elseif ($question->is_critical) {
                    $criticalDisagreements++;
                }
            }
        }

        // Calculate base match percentage
        $matchPercentage = ($matches / $totalQuestions) * 100;

        // Apply penalty for critical disagreements (optional)
        if ($criticalDisagreements > 0) {
            $penalty = ($criticalDisagreements / $totalQuestions) * 10; // 10% penalty per critical disagreement
            $matchPercentage = max(0, $matchPercentage - $penalty);
        }

        // Generate interpretation
        $interpretation = $this->generateInterpretation($matchPercentage, $criticalDisagreements);

        // Save unit score
        UnitScore::updateOrCreate(
            [
                'session_id' => $session->id,
                'unit_id' => $unitId,
            ],
            [
                'match_percentage' => round($matchPercentage, 2),
                'interpretation' => $interpretation,
            ]
        );
    }

    /**
     * Generate interpretation based on match percentage
     */
    private function generateInterpretation(float $matchPercentage, int $criticalDisagreements): string
    {
        if ($criticalDisagreements > 0) {
            return "Muvofiqlik past. Muhim masalalarda kelishmovchiliklar bor.";
        }

        if ($matchPercentage >= 90) {
            return "Juda yuqori muvofiqlik. Juftlik deyarli barcha masalalarda bir xil fikrda.";
        } elseif ($matchPercentage >= 75) {
            return "Yuqori muvofiqlik. Juftlik ko'p masalalarda bir xil fikrda.";
        } elseif ($matchPercentage >= 60) {
            return "O'rtacha muvofiqlik. Ba'zi masalalar bo'yicha kelishmovchiliklar mavjud.";
        } elseif ($matchPercentage >= 40) {
            return "Past muvofiqlik. Ko'plab masalalarda fikrlar farq qiladi.";
        } else {
            return "Juda past muvofiqlik. Juftlik deyarli hech qanday masalada bir xil fikrda emas.";
        }
    }

    /**
     * Get overall compatibility score for a session
     */
    public function getOverallCompatibility(TestSession $session): ?float
    {
        $unitScores = $session->unitScores;
        
        if ($unitScores->isEmpty()) {
            return null;
        }

        return $unitScores->avg('match_percentage');
    }

    /**
     * Get detailed compatibility breakdown
     */
    public function getCompatibilityBreakdown(TestSession $session): array
    {
        $unitScores = $session->unitScores()->with('unit')->get();
        
        $breakdown = [];
        foreach ($unitScores as $score) {
            $breakdown[] = [
                'unit_name' => $score->unit->name,
                'category' => $score->unit->category,
                'match_percentage' => $score->match_percentage,
                'interpretation' => $score->interpretation,
            ];
        }

        return $breakdown;
    }
}
