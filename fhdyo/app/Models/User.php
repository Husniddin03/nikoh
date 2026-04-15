<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'jshshir',
        'gender',
        'test_count',
    ];

    /**
     * Tug'ilgan sanani JSHSHIRdan ajratib olish
     */
    public function getBirthDateAttribute(): ?\Carbon\Carbon
    {

        $jshshir = (string)$this->jshshir;

        if (empty($jshshir) || strlen($jshshir) !== 14) {
            return null;
        }

        // JSHSHIR tarkibi:
        // 1-raqam: Jins va asr indeksi
        // 2-3 raqamlar: Kun (Index 1, length 2)
        // 4-5 raqamlar: Oy  (Index 3, length 2)
        // 6-7 raqamlar: Yil (Index 5, length 2)
        
        $firstDigit = (int)$jshshir[0];
        $day = substr($jshshir, 1, 2);
        $month = substr($jshshir, 3, 2);
        $yearShort = substr($jshshir, 5, 2);

        // Asrni aniqlash (O'zbekiston standarti bo'yicha)
        $century = match($firstDigit) {
            1, 2 => '18',
            3, 4 => '19',
            5, 6 => '20',
            default => '19',
        };

        $fullYear = $century . $yearShort;

        try {
            return \Carbon\Carbon::create($fullYear, $month, $day)->startOfDay();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Yoshni hisoblash
     */
    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }

    public function initiatorSessions(): HasMany
    {
        return $this->hasMany(TestSession::class, 'initiator_id');
    }

    public function partnerSessions(): HasMany
    {
        return $this->hasMany(TestSession::class, 'partner_id');
    }

    public function testSessions()
    {
        return $this->initiatorSessions->merge($this->partnerSessions);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
