<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Couple;
use App\Models\TestResult;
use App\Models\Answer;
use App\Models\Question;
use Carbon\Carbon;

class RealDataSeeder extends Seeder
{
    public function run()
    {
        // Real JSHSHIR raqamlari (O'zbekiston formatida)
        $realJshshirs = [
            '12345678901234', '98765432109876', '11223344556677', '99887766554433',
            '55667788990011', '22334455667788', '77889900112233', '44556677889900',
            '99001122334455', '66778899001122', '33445566778899', '11223344556677',
            '88990011223344', '55667788990011', '22334455667788', '99887766554433',
            '12345678901234', '44556677889900', '77889900112233', '11223344556677',
            '88990011223344', '33445566778899', '55667788990011', '99887766554433',
            '12345678901234', '22334455667788', '44556677889900', '66778899001122',
            '77889900112233', '88990011223344', '99001122334455', '11223344556677',
            '33445566778899', '55667788990011', '99887766554433', '12345678901234'
        ];

        // Real ismlar
        $maleNames = ['Ali', 'Javlon', 'Bekzod', 'Sardor', 'Aziz', 'Umid', 'Jasur', 'Rustam', 'Doniyor', 'Bobur'];
        $femaleNames = ['Dilnoza', 'Zarina', 'Gulnora', 'Nodira', 'Malika', 'Kamola', 'Sevinch', 'Lola', 'Muxlisa', 'Zuhra'];

        // Yanvar oyidagi testlar (15 ta)
        for ($i = 0; $i < 15; $i++) {
            $this->createTestWithDate(
                Carbon::create(2026, 1, rand(5, 30), rand(10, 18), rand(0, 59)),
                $realJshshirs[$i],
                $realJshshirs[$i + 1],
                $maleNames[$i % 10],
                $femaleNames[$i % 10]
            );
        }

        // Fevral oyidagi testlar (18 ta)
        for ($i = 0; $i < 18; $i++) {
            $this->createTestWithDate(
                Carbon::create(2026, 2, rand(1, 28), rand(10, 18), rand(0, 59)),
                $realJshshirs[$i + 15],
                $realJshshirs[$i + 16],
                $maleNames[($i + 5) % 10],
                $femaleNames[($i + 5) % 10]
            );
        }

        // Mart oyidagi testlar (12 ta)
        for ($i = 0; $i < 12; $i++) {
            $this->createTestWithDate(
                Carbon::create(2026, 3, rand(1, 25), rand(10, 18), rand(0, 59)),
                $realJshshirs[$i + 20],
                $realJshshirs[$i + 21],
                $maleNames[($i + 8) % 10],
                $femaleNames[($i + 8) % 10]
            );
        }

        $this->command->info('Real data seeder muvaffaqiyatli yuklandi!');
        $this->command->info('Yanvar: 15 ta test');
        $this->command->info('Fevral: 18 ta test');
        $this->command->info('Mart: 12 ta test');
        $this->command->info('Jami: 45 ta test');
    }

    private function createTestWithDate($date, $jshshir1, $jshshir2, $maleName, $femaleName)
    {
        // Juftlik yaratish
        $couple = Couple::create([
            'jshshir_user' => $jshshir1,
            'jshshir_spouse' => $jshshir2,
        ]);

        // Test natijasi yaratish
        $testResult = TestResult::create([
            'couple_id' => $couple->id,
            'total_score' => 0,
            'max_score' => 50,
            'compatibility_level' => '',
            'section_scores' => [],
            'status' => 'completed',
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        // Barcha savollarga javob berish
        $questions = Question::all();
        $totalScore = 0;

        foreach ($questions as $question) {
            // Real javoblar - ba'zilari yaxshi, ba'zilari o'rtacha, ba'zilari yomon
            $randomScore = rand(0, 2);
            $answer = '';
            
            switch ($randomScore) {
                case 2:
                    $answer = 'yes';
                    break;
                case 1:
                    $answer = 'partially';
                    break;
                case 0:
                    $answer = 'no';
                    break;
            }

            $totalScore += $randomScore;

            Answer::create([
                'test_result_id' => $testResult->id,
                'question_id' => $question->id,
                'score' => $randomScore,
                'answer' => $answer,
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }

        // Test natijasini yangilash
        $percentage = ($totalScore / 50) * 100;
        $compatibilityLevel = '';
        
        if ($percentage >= 80) {
            $compatibilityLevel = 'Juda yaxshi mos keladi';
        } elseif ($percentage >= 60) {
            $compatibilityLevel = 'Yaxshi mos keladi';
        } elseif ($percentage >= 40) {
            $compatibilityLevel = 'Qisman mos keladi';
        } elseif ($percentage >= 20) {
            $compatibilityLevel = 'Kam mos keladi';
        } else {
            $compatibilityLevel = 'Jiddiy mos kelmaslik';
        }

        $testResult->update([
            'total_score' => $totalScore,
            'compatibility_level' => $compatibilityLevel,
        ]);

        return $testResult;
    }
}
