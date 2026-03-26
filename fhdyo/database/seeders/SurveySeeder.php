<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\SurveySection;
use App\Models\Question;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = public_path('nikohga_sorovnoma.txt');
        
        if (!file_exists($filePath)) {
            $this->command->error('Survey file not found: ' . $filePath);
            return;
        }

        $content = file_get_contents($filePath);
        $lines = explode("\n", $content);
        
        $currentSection = null;
        $questionOrder = 1;

        foreach ($lines as $line) {
            $line = trim($line);
            
            if (empty($line)) continue;
            
            if (preg_match('/^(\d+)-BO‘LIM:\s*(.+)$/', $line, $matches)) {
                if ($currentSection) {
                    $currentSection->save();
                }
                
                $currentSection = new SurveySection([
                    'title' => $matches[2],
                    'order' => (int)$matches[1],
                    'max_score' => 100,
                    'is_active' => true
                ]);
                
                $questionOrder = 1;
            }
            elseif (preg_match('/^(\d+)\.\s*(.+)$/', $line, $matches) && $currentSection) {
                $currentSection->save();
                
                Question::create([
                    'survey_section_id' => $currentSection->id,
                    'question_text' => $matches[2],
                    'order' => $questionOrder++,
                    'is_active' => true
                ]);
            }
        }
        
        if ($currentSection) {
            $currentSection->save();
        }
        
        $this->command->info('Survey data seeded successfully!');
    }
}
