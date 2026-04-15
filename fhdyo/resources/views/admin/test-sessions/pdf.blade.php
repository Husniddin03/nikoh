<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juftlik #{{ $testSession->id }} - Nikoh Test Natijalari</title>
    <style>
        @page {
            margin: 20mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 24pt;
            margin: 0;
            color: #000;
        }
        .header p {
            font-size: 10pt;
            color: #666;
            margin: 5px 0 0 0;
        }
        .info-box {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            width: 50%;
            padding: 10px;
            vertical-align: top;
        }
        .user-card {
            background: #fff;
            border: 2px solid #ddd;
            padding: 12px;
            margin-bottom: 10px;
        }
        .user-card.male {
            border-left: 5px solid #3b82f6;
        }
        .user-card.female {
            border-left: 5px solid #ec4899;
        }
        .user-card h4 {
            margin: 0 0 5px 0;
            font-size: 9pt;
            color: #666;
            text-transform: uppercase;
        }
        .user-card .jshshir {
            font-family: monospace;
            font-size: 14pt;
            font-weight: bold;
            margin: 5px 0;
        }
        .user-card .details {
            font-size: 9pt;
            color: #666;
        }
        .compatibility-section {
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            border: 3px solid #333;
        }
        .compatibility-score {
            font-size: 48pt;
            font-weight: bold;
            margin: 10px 0;
        }
        .compatibility-score.high {
            color: #10b981;
        }
        .compatibility-score.medium {
            color: #f59e0b;
        }
        .compatibility-score.low {
            color: #ef4444;
        }
        .verdict {
            font-size: 12pt;
            font-weight: bold;
            padding: 8px 20px;
            display: inline-block;
            margin-top: 10px;
        }
        .verdict.high {
            background: #d1fae5;
            color: #065f46;
        }
        .verdict.medium {
            background: #fef3c7;
            color: #92400e;
        }
        .verdict.low {
            background: #fee2e2;
            color: #991b1b;
        }
        .stats-row {
            display: table;
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        .stat-box {
            display: table-cell;
            width: 20%;
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            background: #f9f9f9;
        }
        .stat-box .number {
            font-size: 20pt;
            font-weight: bold;
            color: #333;
        }
        .stat-box .label {
            font-size: 8pt;
            color: #666;
            text-transform: uppercase;
        }
        .answers-section {
            margin-top: 30px;
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .unit-header {
            background: #e5e7eb;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 10pt;
            margin-top: 15px;
            border-left: 4px solid #6b7280;
        }
        .answer-row {
            display: table;
            width: 100%;
            border-bottom: 1px solid #eee;
            padding: 8px 0;
        }
        .answer-cell {
            display: table-cell;
            padding: 8px;
            vertical-align: middle;
        }
        .answer-cell.question {
            width: 60%;
        }
        .answer-cell.answer {
            width: 20%;
            text-align: center;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge.yes {
            background: #d1fae5;
            color: #065f46;
        }
        .badge.no {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge.missing {
            background: #f3f4f6;
            color: #6b7280;
        }
        .matched-indicator {
            width: 4px;
            display: table-cell;
        }
        .matched-indicator.yes {
            background: #10b981;
        }
        .matched-indicator.no {
            background: #ef4444;
        }
        .footer {
            text-align: center;
            font-size: 8pt;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 30px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>NIKOH TEST NATIJASI</h1>
        <p>Juftlik #{{ $testSession->id }} | {{ $testSession->created_at->format('d.m.Y H:i') }}</p>
    </div>

    <!-- Users Info -->
    <div class="info-box">
        <div class="info-grid">
            <div class="info-row">
                <!-- Initiator -->
                <div class="info-cell">
                    <div class="user-card {{ $testSession->initiator->gender === 'male' ? 'male' : 'female' }}">
                        <h4>Boshlovchi</h4>
                        <div class="jshshir">{{ $testSession->initiator->jshshir }}</div>
                        <div class="details">
                            {{ $testSession->initiator->gender === 'male' ? '♂ Erkak' : '♀ Ayol' }} | 
                            {{ $testSession->initiator->birth_date ? $testSession->initiator->birth_date->format('d.m.Y') : '?' }} | 
                            {{ $testSession->initiator->age ?? '?' }} yosh
                        </div>
                    </div>
                </div>
                <!-- Partner -->
                <div class="info-cell">
                    <div class="user-card {{ $testSession->partner->gender === 'male' ? 'male' : 'female' }}">
                        <h4>Sherik</h4>
                        <div class="jshshir">{{ $testSession->partner->jshshir }}</div>
                        <div class="details">
                            {{ $testSession->partner->gender === 'male' ? '♂ Erkak' : '♀ Ayol' }} | 
                            {{ $testSession->partner->birth_date ? $testSession->partner->birth_date->format('d.m.Y') : '?' }} | 
                            {{ $testSession->partner->age ?? '?' }} yosh
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Compatibility Score -->
    <div class="compatibility-section">
        <div style="font-size: 12pt; color: #666; margin-bottom: 10px;">Muvofiqlik Natijasi</div>
        <div class="compatibility-score {{ $compatibility >= 70 ? 'high' : ($compatibility >= 40 ? 'medium' : 'low') }}">
            {{ $compatibility }}%
        </div>
        <div class="verdict {{ $compatibility >= 70 ? 'high' : ($compatibility >= 40 ? 'medium' : 'low') }}">
            @if($compatibility >= 70)
                A'lo muvofiqlik! Juftlik juda mos.
            @elseif($compatibility >= 40)
                O'rta muvofiqlik. Muzokaralar o'tkazish kerak.
            @else
                Past muvofiqlik. Ehtiyot bo'ling.
            @endif
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="number">{{ $initiatorResults->count() }}</div>
            <div class="label">Savollar soni</div>
        </div>
        <div class="stat-box">
            <div class="number" style="color: #10b981;">{{ $matchedAnswers }}</div>
            <div class="label">Mos javoblar</div>
        </div>
        <div class="stat-box">
            <div class="number" style="color: #ef4444;">{{ $initiatorResults->count() - $matchedAnswers }}</div>
            <div class="label">Mos emas</div>
        </div>
        <div class="stat-box">
            <div class="number" style="color: #3b82f6;">{{ $groupedAnswers->count() }}</div>
            <div class="label">Bo'limlar</div>
        </div>
        <div class="stat-box">
            <div class="number" style="color: #8b5cf6;">{{ $testSession->results->count() }}</div>
            <div class="label">Jami javoblar</div>
        </div>
    </div>

    <!-- Answers Section -->
    <div class="answers-section">
        <div class="section-title">Javoblar Taqqoslash</div>
        
        @foreach($groupedAnswers as $unitName => $answers)
            <div class="unit-header">
                {{ $unitName }} ({{ $answers->count() }} ta savol)
            </div>
            
            <table style="width: 100%; border-collapse: collapse; margin-top: 5px;">
                <thead>
                    <tr style="background: #f3f4f6; font-size: 8pt; text-transform: uppercase;">
                        <th style="padding: 8px; text-align: left; width: 60%;">Savol</th>
                        <th style="padding: 8px; text-align: center; width: 20%;">Boshlovchi</th>
                        <th style="padding: 8px; text-align: center; width: 20%;">Sherik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($answers as $answer)
                        <tr style="border-bottom: 1px solid #eee; {{ $answer['matched'] ? 'background: #ecfdf5;' : 'background: #fef2f2;' }}">
                            <td style="padding: 8px;">{{ $answer['question']->question }}</td>
                            <td style="padding: 8px; text-align: center;">
                                @if($answer['initiator_answer'] === true)
                                    <span class="badge yes">✓ Ha</span>
                                @elseif($answer['initiator_answer'] === false)
                                    <span class="badge no">✗ Yo'q</span>
                                @else
                                    <span class="badge missing">-</span>
                                @endif
                            </td>
                            <td style="padding: 8px; text-align: center;">
                                @if($answer['partner_answer'] === true)
                                    <span class="badge yes">✓ Ha</span>
                                @elseif($answer['partner_answer'] === false)
                                    <span class="badge no">✗ Yo'q</span>
                                @else
                                    <span class="badge missing">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Hujjat avtomatik tarzda yaratildi | {{ now()->format('d.m.Y H:i') }}</p>
        <p>Tizim: Nikoh Test Platformasi | Test ID: {{ $testSession->id }}</p>
    </div>
</body>
</html>
