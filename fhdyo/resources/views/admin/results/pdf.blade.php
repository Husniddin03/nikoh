<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <title>Test Natijasi - {{ $testResult->couple->jshshir_user }}</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #1e40af;
            font-size: 20px;
            margin: 0;
        }
        
        .header p {
            color: #6b7280;
            margin: 3px 0 0 0;
            font-size: 10px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .info-item {
            padding: 8px;
            background: #f8fafc;
            border-radius: 4px;
            border-left: 3px solid #3b82f6;
        }
        
        .info-label {
            font-weight: bold;
            color: #374151;
            margin-bottom: 2px;
            font-size: 9px;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 10px;
        }
        
        .compatibility-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
        }
        
        .badge-juda-yuqori {
            background: #10b981;
            color: white;
        }
        
        .badge-yuqori {
            background: #3b82f6;
            color: white;
        }
        
        .badge-orta {
            background: #f59e0b;
            color: white;
        }
        
        .badge-past {
            background: #ef4444;
            color: white;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            margin: 15px 0 10px 0;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }
        
        .results-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .result-item {
            padding: 8px;
            background: #f9fafb;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .result-title {
            font-weight: bold;
            color: #374151;
            font-size: 10px;
        }
        
        .result-score {
            font-weight: bold;
            color: #1f2937;
            font-size: 12px;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e5e7eb;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 3px;
        }
        
        .progress-high {
            background: linear-gradient(90deg, #10b981, #059669);
        }
        
        .progress-medium {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
        }
        
        .progress-low {
            background: linear-gradient(90deg, #f59e0b, #d97706);
        }
        
        .summary-section {
            margin-top: 20px;
            padding: 15px;
            background: #f0f9ff;
            border-radius: 6px;
            border: 2px solid #3b82f6;
        }
        
        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 8px;
            text-align: center;
        }
        
        .summary-text {
            text-align: center;
            color: #374151;
            font-size: 10px;
            line-height: 1.5;
        }
        
        .footer {
            margin-top: 25px;
            text-align: center;
            color: #6b7280;
            font-size: 9px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nikohga Sorovnoma Test Natijasi</h1>
        <p>Tizim tomonidan avtomatik ravishda yaratilgan hisobot</p>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Test ID</div>
            <div class="info-value">#{{ $testResult->id }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Test Sanasi</div>
            <div class="info-value">{{ $testResult->created_at->format('d.m.Y H:i') }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Foydalanuvchi JSHSHIR</div>
            <div class="info-value">{{ $testResult->couple->jshshir_user }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Jufti JSHSHIR</div>
            <div class="info-value">{{ $testResult->couple->jshshir_spouse }}</div>
        </div>
    </div>
    
    <div style="text-align: center; margin: 15px 0;">
        <div class="info-label" style="margin-bottom: 8px;">Umumiy Moslik Darajasi</div>
        @php
            $percentage = ($testResult->total_score / $testResult->max_score) * 100;
            $badgeClass = 'badge-past';
            $badgeText = 'Past';
            if ($percentage >= 80) {
                $badgeClass = 'badge-juda-yuqori';
                $badgeText = 'Juda Yuqori';
            } elseif ($percentage >= 60) {
                $badgeClass = 'badge-yuqori';
                $badgeText = 'Yuqori';
            } elseif ($percentage >= 40) {
                $badgeClass = 'badge-orta';
                $badgeText = 'O\'rtacha';
            }
        @endphp
        <div class="compatibility-badge {{ $badgeClass }}">
            {{ $badgeText }} - {{ round($percentage) }}%
        </div>
        <div style="margin-top: 8px; font-size: 12px; color: #374151;">
            {{ $testResult->total_score }} / {{ $testResult->max_score }} ball
        </div>
    </div>

    <div class="section-title">Bo'limlar Bo'yicha Natijalar</div>
    <div class="results-grid">
        @foreach($testResult->answers->groupBy('question.survey_section_id') as $sectionId => $answers)
            @php
                $section = $answers->first()->question->surveySection;
                $sectionScore = $answers->sum('score');
                $sectionMax = $answers->count() * 2;
                $sectionPercentage = ($sectionScore / $sectionMax) * 100;
                $progressClass = 'progress-low';
                if ($sectionPercentage >= 70) {
                    $progressClass = 'progress-high';
                } elseif ($sectionPercentage >= 50) {
                    $progressClass = 'progress-medium';
                }
            @endphp
            <div class="result-item">
                <div class="result-header">
                    <div class="result-title">{{ $section->title }}</div>
                    <div class="result-score">{{ $sectionScore }}/{{ $sectionMax }}</div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill {{ $progressClass }}" style="width: {{ $sectionPercentage }}%"></div>
                </div>
                <div style="text-align: center; margin-top: 3px; font-size: 9px; color: #6b7280;">
                    {{ round($sectionPercentage) }}%
                </div>
            </div>
        @endforeach
    </div>

    <div class="summary-section">
        <div class="summary-title">Test Natijalari Xulosasi</div>
        <div class="summary-text">
            @php
                $percentage = ($testResult->total_score / $testResult->max_score) * 100;
                if ($percentage >= 80) {
                    $summary = 'Juftlik o\'rtasida juda yuqori moslik kuzatilmoqda. Ular bir-birlarini tushunishda va oilaviy hayotda muvaffaqiyatli bo\'lishlari kutilmoqda.';
                } elseif ($percentage >= 60) {
                    $summary = 'Juftlik o\'rtasida yuqori moslik bor. Ba\'zi jihatlarda farqlar bo\'lishi mumkin, lekin umumiy manzara ijobiy.';
                } elseif ($percentage >= 40) {
                    $summary = 'Juftlik o\'rtasida o\'rtacha moslik bor. Turli masalalarda bir-birlarini tushunish va kompromiss izlash muhim ahamiyatga ega.';
                } else {
                    $summary = 'Juftlik o\'rtasida past moslik kuzatilmoqda. Oilaviy hayotda muvaffaqiyatli bo\'lish uchun qo\'shimcha harakatlar va bir-birlarini tushunish kerak.';
                }
            @endphp
            {{ $summary }}
        </div>
    </div>

    <div class="footer">
        <p>⚠️ Ushbu hisobot faqatgina ma'lumot maqsadida xizmat qiladi va maslahat sifatida qaralishi kerak.</p>
        <p>Yaratilgan vaqt: {{ now()->format('d.m.Y H:i:s') }} | Tizim: Nikohga Sorovnoma Platformasi</p>
    </div>
</body>
</html>
