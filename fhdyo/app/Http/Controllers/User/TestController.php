<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TestSession;
use App\Models\Question;
use App\Models\Result;
use App\Models\User;
use App\Services\CompatibilityService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TestController extends Controller
{
    protected CompatibilityService $compatibilityService;

    public function __construct(CompatibilityService $compatibilityService)
    {
        $this->compatibilityService = $compatibilityService;
    }

    /**
     * Show the test page with unanswered questions
     */
    public function show(TestSession $session): View
    {
        // Get current user (you might need to implement authentication logic)
        $currentUser = $this->getCurrentUser($session);
        
        // Get unanswered questions for this user in this session
        $answeredQuestionIds = Result::where('session_id', $session->id)
            ->where('user_id', $currentUser->id)
            ->pluck('question_id')
            ->toArray();

        $unansweredQuestions = Question::whereIn('id', $session->question_ids)
            ->whereNotIn('id', $answeredQuestionIds)
            ->with('unit')
            ->get();

        // Get user's progress
        $totalQuestions = count($session->question_ids);
        $answeredCount = count($answeredQuestionIds);
        $progress = ($answeredCount / $totalQuestions) * 100;

        return view('user.test', compact('session', 'unansweredQuestions', 'currentUser', 'progress'));
    }

    /**
     * Submit user's answer
     */
    public function submitAnswer(Request $request, TestSession $session): RedirectResponse
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required|boolean',
        ]);

        $currentUser = $this->getCurrentUser($session);
        $questionId = $request->input('question_id');
        $answer = $request->input('answer');

        // Check if question is part of this session
        if (!in_array($questionId, $session->question_ids)) {
            return redirect()->back()
                ->with('error', 'Bu savol ushbu test sessiyasiga tegishli emas.');
        }

        // Check if user already answered this question
        $existingResult = Result::where('session_id', $session->id)
            ->where('user_id', $currentUser->id)
            ->where('question_id', $questionId)
            ->first();

        if ($existingResult) {
            return redirect()->back()
                ->with('error', 'Siz bu savolga allaqachon javob bergansiz.');
        }

        // Save the answer
        Result::create([
            'session_id' => $session->id,
            'user_id' => $currentUser->id,
            'question_id' => $questionId,
            'answer' => $answer,
        ]);

        // Check if user has finished all questions
        $userAnsweredCount = Result::where('session_id', $session->id)
            ->where('user_id', $currentUser->id)
            ->count();

        $totalQuestions = count($session->question_ids);
        
        if ($userAnsweredCount >= $totalQuestions) {
            // Check if both users have finished
            $initiatorAnsweredCount = Result::where('session_id', $session->id)
                ->where('user_id', $session->initiator_id)
                ->count();

            $partnerAnsweredCount = Result::where('session_id', $session->id)
                ->where('user_id', $session->partner_id)
                ->count();

            if ($initiatorAnsweredCount >= $totalQuestions && $partnerAnsweredCount >= $totalQuestions) {
                // Both users finished, calculate compatibility
                $this->compatibilityService->calculate($session);
                
                return redirect()->route('test.results', $session->id)
                    ->with('success', 'Test tugadi! Natijalar hisoblandi.');
            }
        }

        return redirect()->route('test.show', $session->id)
            ->with('success', 'Javob saqlandi.');
    }

    /**
     * Show test results
     */
    public function results(TestSession $session): View
    {
        $unitScores = $session->unitScores()->with('unit')->get();
        
        return view('user.results', compact('session', 'unitScores'));
    }

    /**
     * Get current user based on session context
     * This is a placeholder - implement your actual authentication logic
     */
    private function getCurrentUser(TestSession $session): User
    {
        // You need to implement proper authentication here
        // For now, return the initiator as example
        return $session->initiator;
        
        // In real implementation, you might do:
        // return auth()->user();
        // Or check session data to determine current user
    }
}
