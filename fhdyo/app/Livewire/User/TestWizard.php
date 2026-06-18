<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\TestSession;
use App\Models\Question;
use App\Models\Result;
use App\Services\CompatibilityService;
use App\Models\User;

class TestWizard extends Component
{
    public TestSession $session;
    public array $questions = [];
    public int $currentQuestionIndex = 0;
    public array $answers = [];
    public bool $isCalculating = false;
    public bool $isCompleted = false;
    public User $currentUser;

    protected CompatibilityService $compatibilityService;

    public function mount(TestSession $session): void
    {
        $this->session = $session;
        $this->currentUser = $this->getCurrentUser();
        
        // If session is already completed, redirect to results
        if ($session->status === 'completed') {
            $this->redirectRoute('user.results', $session->id, navigate: false);
            return;
        }
        
        // Check if there are questions in the session
        if (empty($session->question_ids) || !is_array($session->question_ids)) {
            $this->questions = [];
            return;
        }
        
        // Load questions for this session
        $questionIds = $session->question_ids;
        $orderByField = implode(',', $questionIds);
        
        $this->questions = Question::whereIn('id', $questionIds)
            ->with('unit')
            ->orderByRaw("FIELD(id, {$orderByField})")
            ->get()
            ->toArray();

        // Load user's existing answers
        $existingAnswers = Result::where('session_id', $session->id)
            ->where('user_id', $this->currentUser->id)
            ->pluck('answer', 'question_id')
            ->toArray();

        $this->answers = $existingAnswers;

        // Find the first unanswered question
        $this->findNextUnansweredQuestion();
        
        // Check if current user has finished and both users are done
        $this->checkIfBothCompleted();
    }
    
    /**
     * Check if both users have completed the test and redirect to results
     */
    private function checkIfBothCompleted(): void
    {
        $totalQuestions = count($this->questions);
        
        // Check if current user has finished
        $userAnsweredCount = Result::where('session_id', $this->session->id)
            ->where('user_id', $this->currentUser->id)
            ->count();
        
        if ($userAnsweredCount >= $totalQuestions) {
            // Check if both users have finished
            $initiatorAnsweredCount = Result::where('session_id', $this->session->id)
                ->where('user_id', $this->session->initiator_id)
                ->count();

            $partnerAnsweredCount = Result::where('session_id', $this->session->id)
                ->where('user_id', $this->session->partner_id)
                ->count();

            if ($initiatorAnsweredCount >= $totalQuestions && $partnerAnsweredCount >= $totalQuestions) {
                // Calculate compatibility if not already done
                if ($this->session->status !== 'completed') {
                    $this->compatibilityService->calculate($this->session);
                }
                
                $this->redirectRoute('user.results', $this->session->id, navigate: false);
            }
        }
    }

    public function boot(CompatibilityService $compatibilityService): void
    {
        $this->compatibilityService = $compatibilityService;
    }

    public function answerQuestion(bool $answer): void
    {
        if ($this->isCalculating || $this->isCompleted) {
            return;
        }

        $currentQuestion = $this->getCurrentQuestion();
        
        if (!$currentQuestion) {
            return;
        }

        // Save the answer
        Result::updateOrCreate([
            'session_id' => $this->session->id,
            'user_id' => $this->currentUser->id,
            'question_id' => $currentQuestion['id'],
        ], [
            'answer' => $answer,
        ]);

        $this->answers[$currentQuestion['id']] = $answer;

        // Move to next question
        $this->currentQuestionIndex++;
        $this->findNextUnansweredQuestion();

        // Check if all questions are answered
        if ($this->currentQuestionIndex >= count($this->questions)) {
            $this->checkIfTestCompleted();
        }
    }

    private function findNextUnansweredQuestion(): void
    {
        for ($i = 0; $i < count($this->questions); $i++) {
            $questionId = $this->questions[$i]['id'];
            if (!isset($this->answers[$questionId])) {
                $this->currentQuestionIndex = $i;
                return;
            }
        }
        
        // All questions are answered
        $this->currentQuestionIndex = count($this->questions);
    }

    private function checkIfTestCompleted(): void
    {
        $totalQuestions = count($this->questions);
        $userAnsweredCount = Result::where('session_id', $this->session->id)
            ->where('user_id', $this->currentUser->id)
            ->count();

        if ($userAnsweredCount >= $totalQuestions) {
            // Store count before checking
            $initiatorAnsweredCount = Result::where('session_id', $this->session->id)
                ->where('user_id', $this->session->initiator_id)
                ->count();

            $partnerAnsweredCount = Result::where('session_id', $this->session->id)
                ->where('user_id', $this->session->partner_id)
                ->count();
            
            // If both finished, calculate and redirect
            if ($initiatorAnsweredCount >= $totalQuestions && $partnerAnsweredCount >= $totalQuestions) {
                $this->isCalculating = true;
                
                // Calculate compatibility
                $this->compatibilityService->calculate($this->session);
                // Redirect to results
                $this->redirectRoute('user.results', $this->session->id, navigate: false);
                return;
            }
            
            // Only this user finished, mark as waiting
            $this->isCompleted = true;
        }
    }

    public function getCurrentQuestion(): ?array
    {
        if ($this->currentQuestionIndex >= 0 && $this->currentQuestionIndex < count($this->questions)) {
            return $this->questions[$this->currentQuestionIndex];
        }
        
        return null;
    }

    public function getProgress(): float
    {
        $totalQuestions = count($this->questions);
        $answeredCount = count($this->answers);
        
        return $totalQuestions > 0 ? ($answeredCount / $totalQuestions) * 100 : 0;
    }

    public function getAnsweredCount(): int
    {
        return count($this->answers);
    }

    public function getTotalQuestions(): int
    {
        return count($this->questions);
    }

    private function getCurrentUser(): User
    {
        // Check if there's a user_jshshir in the session (set during entry)
        $userJshshir = session('user_jshshir');
        
        if ($userJshshir) {
            // Find user by JSHSHIR
            $user = User::where('jshshir', $userJshshir)->first();
            if ($user) {
                return $user;
            }
        }
        
        // Fallback: try to determine from session relationship
        // Check if the stored JSHSHIR matches initiator or partner
        if (isset($this->session->initiator->jshshir) && $this->session->initiator->jshshir == $userJshshir) {
            return $this->session->initiator;
        }
        
        if (isset($this->session->partner->jshshir) && $this->session->partner->jshshir == $userJshshir) {
            return $this->session->partner;
        }
        
        // Default to initiator if can't determine
        return $this->session->initiator;
    }

    public function render()
    {
        return view('livewire.user.test-wizard');
    }
}
