<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveySection extends Model
{
    protected $fillable = [
        'title',
        'description',
        'order',
        'max_score',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function activeQuestions(): HasMany
    {
        return $this->hasMany(Question::class)->where('is_active', true);
    }
}
