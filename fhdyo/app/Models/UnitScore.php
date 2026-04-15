<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'unit_id',
        'match_percentage',
        'interpretation',
    ];

    protected $casts = [
        'match_percentage' => 'float',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(TestSession::class, 'session_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
