<?php

namespace App\Jobs;

use App\Models\TestSession;
use App\Services\AiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GenerateAiResultJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $sessionId
    ) {}

    public function handle(AiService $aiService)
    {
        $session = TestSession::find($this->sessionId);

        $answersComparison = app(\App\Http\Controllers\User\ResultController::class)
            ->getAnswersComparison(
                $session,
                $session->initiator,
                $session->partner,
            );

        $result = $aiService->answerAi($answersComparison);

        $session->update([
            'ai_result' => $result,
            'ai_generated' => true,
        ]);
    }
}
