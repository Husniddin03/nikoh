<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'survey_section_id',
        'question_text',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function surveySection(): BelongsTo
    {
        return $this->belongsTo(SurveySection::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
