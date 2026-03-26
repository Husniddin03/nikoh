<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = [
        'test_result_id',
        'question_id',
        'score',
        'answer'
    ];

    public function testResult(): BelongsTo
    {
        return $this->belongsTo(TestResult::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public static function getScoreFromAnswer(string $answer): int
    {
        return match($answer) {
            'yes' => 2,
            'partially' => 1,
            'no' => 0,
            default => 0
        };
    }
}
