<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestResult extends Model
{
    protected $fillable = [
        'couple_id',
        'total_score',
        'max_score',
        'compatibility_level',
        'section_scores',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'section_scores' => 'array',
        'completed_at' => 'datetime'
    ];

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function calculateCompatibilityLevel(): string
    {
        $percentage = ($this->total_score / $this->max_score) * 100;

        return match(true) {
            $percentage >= 90 => 'Juda mos',
            $percentage >= 70 => 'Yaxshi mos',
            $percentage >= 50 => 'Oʻrtacha mos',
            $percentage >= 30 => 'Notoʻgʻri moslik ehtimoli yuqori',
            default => 'Jiddiy mos kelmaslik'
        };
    }
}
