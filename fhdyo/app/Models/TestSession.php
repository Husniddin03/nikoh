<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'initiator_id',
        'partner_id',
        'category',
        'question_ids',
        'status',
    ];

    protected $casts = [
        'question_ids' => 'array',
    ];

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'session_id');
    }

    public function unitScores(): HasMany
    {
        return $this->hasMany(UnitScore::class, 'session_id');
    }

    /**
     * Check if initiator has completed their test
     */
    public function isInitiatorCompleted(): bool
    {
        return $this->results()->where('user_id', $this->initiator_id)->count() > 0;
    }

    /**
     * Check if partner has completed their test
     */
    public function isPartnerCompleted(): bool
    {
        return $this->results()->where('user_id', $this->partner_id)->count() > 0;
    }
}
