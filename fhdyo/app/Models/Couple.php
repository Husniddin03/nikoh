<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Couple extends Model
{
    use HasFactory;

    protected $fillable = [
        'jshshir_user',
        'jshshir_spouse',
    ];

    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function latestTestResult()
    {
        return $this->testResults()->latest()->first();
    }
}
