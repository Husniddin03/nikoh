<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiService
{
    public function answerAi(array $answersComparison)
    {
        // Ma'lumotlarni tokenlarni tejash uchun ixcham matn holatiga keltiramiz
        $resultText = $this->answersToCompactText($answersComparison);
        $response = Http::withToken(config('services.ai.key'))
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post(config('services.ai.url'), [
                'model' => config('services.ai.model'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => config('services.ai.content')
                    ],
                    [
                        'role' => 'user',
                        'content' => $resultText
                    ]
                ],
                'temperature' => 0.4, // Javoblar aniq va lofirsiz bo'lishi uchun haroratni pasaytirdik
                'max_tokens' => 500,  // AI juda uzun maqola yozib tokenlarni tugatib qo'ymasligi uchun cheklov
            ]);

        if ($response->successful()) {
            $aiData = $response->json();
            return $aiData['choices'][0]['message']['content'] ?? 'AI tahlilida xatolik.';
        }

        // Agar xatolik (masalan 429) bo'lsa logga yozamiz va foydalanuvchiga chiroyli xabar beramiz
        \Log::error('Groq AI Xatoligi: ' . $response->body());

        return 'Hozirda AI xizmati band (Limit to\'lgan). Iltimos, bir ozdan so\'ng "Yangilash" tugmasini bosib qayta urining.';
    }

    /**
     * Tokenlarni maksimal darajada tejaydigan ixcham formatuvchi
     */
    public function answersToCompactText(array $data): string
    {
        $total = count($data);
        $matches = count(array_filter($data, fn($a) => $a['is_match']));
        $mismatches = $total - $matches;

        // Bo'limlar bo'yicha savollarni guruhlash uchun massiv
        $groupedData = [];

        foreach ($data as $item) {
            $unitName = $item['unit_name'];

            // Ha: "+", Yo'q: "-"
            $uAns = $item['user_answer'] ? '+' : '-';
            $pAns = $item['partner_answer'] ? '+' : '-';

            // Agar savol muhim (kritik) bo'lsa, oldiga [*] belgisini qo'yamiz
            $criticalTag = $item['is_critical'] ? '[*] ' : '';

            // Har bir savolni ixcham satr ko'rinishida yig'amiz
            $line = "  {$criticalTag}{$item['question']} ({$uAns}/{$pAns})";

            // Bo'lim nomi bo'yicha guruhga joylaymiz
            $groupedData[$unitName][] = $line;
        }

        // AI uchun yakuniy ixcham matn shakllantiriladi
        $text = "STATISTIKA: Jami:{$total} | Mos:{$matches} | Zid:{$mismatches}\n\n";
        $text .= "=== BO'LIMLAR BO'YICHA JAVOBLAR (Siz/Sherik) ===\n";

        foreach ($groupedData as $unit => $questions) {
            // Bo'lim nomini faqat bir marta boshida yozamiz (Takrorlanish yo'qoladi!)
            $text .= "\n{$unit}:\n";
            $text .= implode("\n", $questions) . "\n";
        }

        return $text;
    }
}