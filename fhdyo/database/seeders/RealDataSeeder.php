<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TestSession;
use App\Models\Result;
use App\Models\Question;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RealDataSeeder extends Seeder
{
    /**
     * Run the database seeds with real JSHSHIR and test data for Jan-Apr 2026
     */
    public function run(): void
    {
        $this->command->info('Creating users with real JSHSHIR numbers...');
        
        // Get or create units and questions for tests
        $units = Unit::all();
        if ($units->isEmpty()) {
            $this->createDefaultUnitsAndQuestions();
            $units = Unit::all();
        }
        
        $questions = Question::all();
        if ($questions->isEmpty()) {
            $this->command->error('No questions found! Please seed questions first.');
            return;
        }
        
        // Create users with real JSHSHIR for 2026 (Jan-Apr)
        $users = $this->createRealUsers();
        
        $this->command->info('Creating test sessions for Jan-Apr 2026...');
        
        // Create test sessions for each month
        $months = [
            ['year' => 2026, 'month' => 1, 'name' => 'Yanvar'],
            ['year' => 2026, 'month' => 2, 'name' => 'Fevral'],
            ['year' => 2026, 'month' => 3, 'name' => 'Mart'],
            ['year' => 2026, 'month' => 4, 'name' => 'Aprel'],
        ];
        
        foreach ($months as $monthData) {
            $this->command->info("Processing {$monthData['name']} 2026...");
            $this->createTestsForMonth($users, $monthData['year'], $monthData['month'], $questions);
        }
        
        $this->command->info('Real data seeding completed!');
        $this->command->info("Total users: " . User::count());
        $this->command->info("Total test sessions: " . TestSession::count());
        $this->command->info("Total results: " . Result::count());
    }
    
    /**
     * Create users with realistic JSHSHIR numbers
     */
    private function createRealUsers(): array
    {
        $users = [];

        $maleUsers = [
            // 1900-yillar (Indeks 3)
            ['jshshir' => '31508855670012', 'gender' => 'male'], // 15.08.1985
            ['jshshir' => '32010904560091', 'gender' => 'male'], // 20.10.1990
            ['jshshir' => '30504924510045', 'gender' => 'male'], // 05.04.1992
            ['jshshir' => '31212954560090', 'gender' => 'male'], // 12.12.1995
            ['jshshir' => '32801984560092', 'gender' => 'male'], // 28.01.1998
            ['jshshir' => '30906995670001', 'gender' => 'male'], // 09.06.1999
            ['jshshir' => '31703884560034', 'gender' => 'male'], // 17.03.1988
            ['jshshir' => '32211944560001', 'gender' => 'male'], // 22.11.1994
            ['jshshir' => '31010824560090', 'gender' => 'male'], // 10.10.1982
            ['jshshir' => '31505874560012', 'gender' => 'male'], // 15.05.1987
            ['jshshir' => '32008915670012', 'gender' => 'male'], // 20.08.1991
            ['jshshir' => '31012934560091', 'gender' => 'male'], // 10.12.1993
            ['jshshir' => '30503964510045', 'gender' => 'male'], // 05.03.1996
            ['jshshir' => '31201844560090', 'gender' => 'male'], // 12.01.1984
            ['jshshir' => '32507894560092', 'gender' => 'male'], // 25.07.1989
            // 2000-yillar (Indeks 5)
            ['jshshir' => '50101004560090', 'gender' => 'male'], // 01.01.2000
            ['jshshir' => '51505024560012', 'gender' => 'male'], // 15.05.2002
            ['jshshir' => '52008035670012', 'gender' => 'male'], // 20.08.2003
            ['jshshir' => '51010044560091', 'gender' => 'male'], // 10.10.2004
            ['jshshir' => '50503054510045', 'gender' => 'male'], // 05.03.2005
            ['jshshir' => '51212064560090', 'gender' => 'male'], // 12.12.2006
            ['jshshir' => '52501074560092', 'gender' => 'male'], // 25.01.2007
            ['jshshir' => '51402014560001', 'gender' => 'male'], // 14.02.2001
            ['jshshir' => '51804034560034', 'gender' => 'male'], // 18.04.2003
            ['jshshir' => '52206054560001', 'gender' => 'male'], // 22.06.2005
            ['jshshir' => '52909004560090', 'gender' => 'male'], // 29.09.2000
            ['jshshir' => '50707024560012', 'gender' => 'male'], // 07.07.2002
            ['jshshir' => '51103045670012', 'gender' => 'male'], // 11.03.2004
            ['jshshir' => '51905064560091', 'gender' => 'male'], // 19.05.2006
            ['jshshir' => '52111054510045', 'gender' => 'male'], // 21.11.2005
        ];

        $femaleUsers = [
            // 1900-yillar (Indeks 4)
            ['jshshir' => '41605865670012', 'gender' => 'female'], // 16.05.1986
            ['jshshir' => '41107915670023', 'gender' => 'female'], // 11.07.1991
            ['jshshir' => '42502885670001', 'gender' => 'female'], // 25.02.1988
            ['jshshir' => '40910925670001', 'gender' => 'female'], // 09.10.1992
            ['jshshir' => '40709975670001', 'gender' => 'female'], // 07.09.1997
            ['jshshir' => '41812995670012', 'gender' => 'female'], // 18.12.1999
            ['jshshir' => '40504945670023', 'gender' => 'female'], // 05.04.1994
            ['jshshir' => '43003955670001', 'gender' => 'female'], // 30.03.1995
            ['jshshir' => '41201825670012', 'gender' => 'female'], // 12.01.1982
            ['jshshir' => '41505875670023', 'gender' => 'female'], // 15.05.1987
            ['jshshir' => '42008895670001', 'gender' => 'female'], // 20.08.1989
            ['jshshir' => '41010935670001', 'gender' => 'female'], // 10.10.1993
            ['jshshir' => '40503965670001', 'gender' => 'female'], // 05.03.1996
            ['jshshir' => '41201985670012', 'gender' => 'female'], // 12.01.1998
            ['jshshir' => '42507855670023', 'gender' => 'female'], // 25.07.1985
            // 2000-yillar (Indeks 6)
            ['jshshir' => '62603015670001', 'gender' => 'female'], // 26.03.2001
            ['jshshir' => '60210025670012', 'gender' => 'female'], // 02.10.2002
            ['jshshir' => '61908035670012', 'gender' => 'female'], // 19.08.2003
            ['jshshir' => '61201045670023', 'gender' => 'female'], // 12.01.2004
            ['jshshir' => '61703055670012', 'gender' => 'female'], // 17.03.2005
            ['jshshir' => '60511065670001', 'gender' => 'female'], // 05.11.2006
            ['jshshir' => '62207075670012', 'gender' => 'female'], // 22.07.2007
            ['jshshir' => '61402015670012', 'gender' => 'female'], // 14.02.2001
            ['jshshir' => '61804025670023', 'gender' => 'female'], // 18.04.2002
            ['jshshir' => '62206045670001', 'gender' => 'female'], // 22.06.2004
            ['jshshir' => '62909055670001', 'gender' => 'female'], // 29.09.2005
            ['jshshir' => '60707005670001', 'gender' => 'female'], // 07.07.2000
            ['jshshir' => '61103065670012', 'gender' => 'female'], // 11.03.2006
            ['jshshir' => '61905055670023', 'gender' => 'female'], // 19.05.2005
            ['jshshir' => '62111035670001', 'gender' => 'female'], // 21.11.2003
        ];
        
        $allUsers = array_merge($maleUsers, $femaleUsers);
        
        foreach ($allUsers as $userData) {
            $user = User::updateOrCreate(
                ['jshshir' => $userData['jshshir']],
                [
                    'jshshir' => $userData['jshshir'],
                    'gender' => $userData['gender'],
                ]
            );
            $users[] = $user;
            $this->command->info("Created user: {$user->jshshir} - {$user->gender}");
        }
        
        return $users;
    }
    
    /**
     * Create test sessions for a specific month
     */
    private function createTestsForMonth(array $users, int $year, int $month, $questions): void
    {
        // Number of days in month
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        
        // Create 3-5 pairs per day
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            
            // Skip some days randomly (simulate weekends/holidays)
            if (rand(1, 10) <= 2) {
                continue;
            }
            
            // Number of tests for this day (3-6 tests)
            $testsForDay = rand(3, 6);
            
            for ($i = 0; $i < $testsForDay; $i++) {
                // Pick random initiator and partner (different genders ideally)
                $initiator = $users[array_rand($users)];
                $partner = $users[array_rand($users)];
                
                // Ensure they're different
                while ($partner->id === $initiator->id) {
                    $partner = $users[array_rand($users)];
                }
                
                // Get random subset of questions (20-30 questions)
                $selectedQuestions = $questions->random(min(rand(20, 30), $questions->count()));
                
                // Create test session
                $testTime = $date->copy()->setHour(rand(9, 18))->setMinute(rand(0, 59));
                
                $testSession = TestSession::create([
                    'initiator_id' => $initiator->id,
                    'partner_id' => $partner->id,
                    'category' => 'nikoh',
                    'question_ids' => $selectedQuestions->pluck('id')->toArray(),
                    'status' => 'completed',
                    'created_at' => $testTime,
                    'updated_at' => $testTime,
                ]);
                
                // Create results for both users (simulate test completion)
                $this->createResultsForTest($testSession, $initiator, $partner, $selectedQuestions, $testTime);
                
                // Create unit scores
                $this->createUnitScoresForTest($testSession);
            }
        }
    }
    
    /**
     * Create results for a test session
     */
    private function createResultsForTest($testSession, $initiator, $partner, $questions, $testTime): void
    {
        foreach ($questions as $question) {
            // Initiator's answer (random but with some consistency)
            Result::create([
                'session_id' => $testSession->id,
                'user_id' => $initiator->id,
                'question_id' => $question->id,
                'answer' => rand(1, 10) > 3, // 70% yes
                'created_at' => $testTime,
                'updated_at' => $testTime,
            ]);
            
            // Partner's answer (random but with some consistency)
            Result::create([
                'session_id' => $testSession->id,
                'user_id' => $partner->id,
                'question_id' => $question->id,
                'answer' => rand(1, 10) > 3, // 70% yes
                'created_at' => $testTime,
                'updated_at' => $testTime,
            ]);
        }
    }
    
    /**
     * Create unit scores for test
     */
    private function createUnitScoresForTest($testSession): void
    {
        $units = Unit::all();
        
        foreach ($units as $unit) {
            // Random match percentage for each unit
            \App\Models\UnitScore::create([
                'session_id' => $testSession->id,
                'unit_id' => $unit->id,
                'match_percentage' => rand(40, 95),
                'interpretation' => null,
            ]);
        }
    }
    
    /**
     * Create default units and questions if none exist
     */
    private function createDefaultUnitsAndQuestions(): void
    {
        $this->command->info('Creating default units and questions...');
        
        $units = [
            ['name' => 'Umumiy qiziqishlar', 'description' => 'Umumiy qiziqishlar va hobbiylar'],
            ['name' => 'Oilaviy qadriyatlar', 'description' => 'Oilaviy munosabatlar va qadriyatlar'],
            ['name' => 'Madaniyat va san\'at', 'description' => 'Madaniy faoliyat va san\'at'],
            ['name' => 'Sport va sog\'lom turmush', 'description' => 'Sport va sog\'lom turmush tarzi'],
        ];
        
        foreach ($units as $unitData) {
            $unit = Unit::create($unitData);
            
            // Create 5-8 questions per unit
            for ($i = 1; $i <= rand(5, 8); $i++) {
                Question::create([
                    'unit_id' => $unit->id,
                    'question' => "Savol {$unit->name} bo'yicha #{$i}: Bu soha sizga qiziqmi?",
                    'is_critical' => rand(1, 4) === 1,
                ]);
            }
        }
    }
}
