<?php

namespace App\Services;

use App\Models\TestSession;
use App\Models\User;
use App\Models\Unit;
use App\Models\Question;

class JshshirService
{
    /**
     * Validate JSHSHIR format and checksum
     */
    public function validateJshshir(string $jshshir): bool
    {
        // Check if exactly 14 digits
        if (!preg_match('/^\d{14}$/', $jshshir)) {
            return false;
        }

        // Validate checksum using weights [7, 3, 1, 7, 3, 1, 7, 3, 1, 7, 3, 1, 7]
        $weights = [7, 3, 1, 7, 3, 1, 7, 3, 1, 7, 3, 1, 7];
        $sum = 0;

        for ($i = 0; $i < 13; $i++) {
            $sum += (int)$jshshir[$i] * $weights[$i];
        }

        $checkDigit = $sum % 10;
        $actualCheckDigit = (int)$jshshir[13];

        return $checkDigit === $actualCheckDigit;
    }

    /**
     * Detect gender from JSHSHIR
     */
    public function detectGender(string $jshshir): string
    {
        $firstDigit = (int)$jshshir[0];
        
        return in_array($firstDigit, [1, 3, 5]) ? 'male' : 'female';
    }

    /**
     * Extract birth year from JSHSHIR
     */
    public function extractBirthYear(string $jshshir): int
    {
        $firstDigit = (int)$jshshir[0];
        $yearDigits = (int)substr($jshshir, 5, 2);
        
        if (in_array($firstDigit, [1, 2])) return 1800 + $yearDigits;
        if (in_array($firstDigit, [3, 4])) return 1900 + $yearDigits;
        if (in_array($firstDigit, [5, 6])) return 2000 + $yearDigits;
        
        return 1900 + $yearDigits;
    }

    /**
     * Check if person is 18 years or older
     */
    public function isAdult(string $jshshir): bool
    {
        $birthYear = $this->extractBirthYear($jshshir);
        $currentYear = (int)date('Y');
        
        return ($currentYear - $birthYear) >= 18;
    }

    /**
     * Check if JSHSHIR is already in use by another user
     */
    public function isJshshirAvailable(string $jshshir): bool
    {
        return !User::where('jshshir', $jshshir)->exists();
    }

    /**
     * Check if a test session already exists between two users
     */
    public function hasActiveSession(string $jshshir1, string $jshshir2): bool
    {
        $user1 = User::where('jshshir', $jshshir1)->first();
        $user2 = User::where('jshshir', $jshshir2)->first();

        if (!$user1 || !$user2) {
            return false;
        }

        return TestSession::where(function ($query) use ($user1, $user2) {
            $query->where('initiator_id', $user1->id)
                  ->where('partner_id', $user2->id);
        })->orWhere(function ($query) use ($user1, $user2) {
            $query->where('initiator_id', $user2->id)
                  ->where('partner_id', $user1->id);
        })->exists();
    }

    /**
     * Get or create user by JSHSHIR
     */
    public function getOrCreateUser(string $jshshir): User
    {
        $user = User::where('jshshir', $jshshir)->first();
        
        if (!$user) {
            $gender = $this->detectGender($jshshir);
            $user = User::create([
                'jshshir' => $jshshir,
                'gender' => $gender,
                'test_count' => 5,
            ]);
        }

        return $user;
    }

    /**
     * Get random questions from each unit by category
     */
    public function getRandomQuestionsFromUnits(string $category = 'nikoh'): array
    {
        $questionIds = [];
        $units = Unit::where('category', $category)->get();

        foreach ($units as $unit) {
            $questions = $unit->questions()
                ->inRandomOrder()
                ->limit(5)
                ->pluck('id')
                ->toArray();
            
            $questionIds = array_merge($questionIds, $questions);
        }

        return $questionIds;
    }

    /**
     * Create test session between two users
     */
    public function createTestSession(User $initiator, User $partner, string $category = 'nikoh'): TestSession
    {
        $questionIds = $this->getRandomQuestionsFromUnits($category);

        return TestSession::create([
            'initiator_id' => $initiator->id,
            'partner_id' => $partner->id,
            'category' => $category,
            'question_ids' => $questionIds,
            'status' => 'waiting',
        ]);
    }
}
