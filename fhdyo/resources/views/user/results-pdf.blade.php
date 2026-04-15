<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nikoh Testi - Natijalar</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ storage_path("fonts/DejaVuSans.ttf") }}') format('truetype');
        }
        
        * {
            font-family: 'DejaVu Sans', sans-serif;
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 40px;
            font-size: 12px;
            line-height: 1.6;
            color: #000;
        }
        
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 22px;
            font-weight: bold;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            color: #1e1b4b;
        }
        
        .header .subtitle {
            font-size: 14px;
            color: #4b5563;
        }
        
        .official-stamp {
            border: 1px solid #4f46e5;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            background-color: #eef2ff;
        }
        
        .official-stamp h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #4338ca;
        }
        
        .info-section {
            margin: 25px 0;
        }
        
        .info-section h3 {
            font-size: 14px;
            font-weight: bold;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin-bottom: 15px;
            color: #374151;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .info-table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .info-table .label {
            background-color: #f3f4f6;
            font-weight: bold;
            width: 40%;
            color: #374151;
        }
        
        .score-section {
            margin: 30px 0;
            text-align: center;
            border: 1px solid #e5e7eb;
            padding: 20px;
            background-color: #fafafa;
        }
        
        .score-section .score-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #6b7280;
        }
        
        .score-section .score-value {
            font-size: 48px;
            font-weight: bold;
            color: #4f46e5;
        }
        
        .score-section .score-label {
            font-size: 14px;
            margin-top: 10px;
            color: #374151;
        }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .results-table th {
            background-color: #4f46e5;
            color: #fff;
            padding: 10px;
            border: 1px solid #e5e7eb;
            text-align: left;
            font-weight: bold;
        }
        
        .results-table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        
        .results-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .percentage {
            font-weight: bold;
            color: #059669;
        }
        
        .footer {
            margin-top: 40px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            font-size: 10px;
            color: #6b7280;
        }
        
        .disclaimer {
            border: 1px solid #fcd34d;
            padding: 15px;
            margin: 20px 0;
            background-color: #fffbeb;
        }
        
        .disclaimer h4 {
            font-weight: bold;
            margin: 0 0 10px 0;
            color: #92400e;
        }
        
        .signatures {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            padding-top: 5px;
            font-size: 11px;
        }
        
        .date-location {
            margin: 30px 0;
            text-align: right;
        }
        
        .qr-placeholder {
            border: 1px solid #d1d5db;
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>O'zbekiston Respublikasi</h1>
        <div class="subtitle">
            {{ $session->category === 'nikoh' ? 'NIKOH MUVOFIQLIKI' : 'AFRIM SABALARI' }} TESTI NATIJALARI
        </div>
    </div>
    
    <!-- Official Stamp Section -->
    <div class="official-stamp">
        <h2>RASMIY HUJJAT</h2>
        <p>Hujjat raqami: NT-{{ $session->id }}-{{ date('Y') }}</p>
        <p>Test sanasi: {{ $session->updated_at->format('d.m.Y') }}</p>
    </div>
    
    <!-- Participants Info -->
    <div class="info-section">
        <h3>ISHTIROKCHILAR MA'LUMOTLARI</h3>
        <table class="info-table">
            <tr>
                <td class="label">Birinchi ishtirokchi (JSHSHIR):</td>
                <td>{{ $currentUser->jshshir }}</td>
            </tr>
            <tr>
                <td class="label">Birinchi ishtirokchi jinsi:</td>
                <td>{{ $currentUser->gender === 'male' ? 'Erkak' : 'Ayol' }}</td>
            </tr>
            <tr>
                <td class="label">Ikkinchi ishtirokchi (JSHSHIR):</td>
                <td>{{ $partner->jshshir }}</td>
            </tr>
            <tr>
                <td class="label">Ikkinchi ishtirokchi jinsi:</td>
                <td>{{ $partner->gender === 'male' ? 'Erkak' : 'Ayol' }}</td>
            </tr>
            <tr>
                <td class="label">Test turi:</td>
                <td>{{ $session->category === 'nikoh' ? 'Nikoh muvofiqligi' : 'Ajrim sabablari' }}</td>
            </tr>
            <tr>
                <td class="label">Savollar soni:</td>
                <td>{{ count($session->question_ids ?? []) }}</td>
            </tr>
        </table>
    </div>
    
    <!-- Overall Score -->
    <div class="score-section">
        <div class="score-title">UMUMIY MUVOFIQLIK FOIZI</div>
        <div class="score-value">{{ $overallCompatibility !== null ? number_format($overallCompatibility, 1) : '0.0' }}%</div>
        <div class="score-label">
            @if($overallCompatibility === null)
                Natijalar mavjud emas
            @elseif($overallCompatibility >= 75)
                Yuqori muvofiqlik
            @elseif($overallCompatibility >= 50)
                O'rtacha muvofiqlik
            @else
                Past muvofiqlik
            @endif
        </div>
    </div>
    
    <!-- Detailed Results -->
    <div class="info-section">
        <h3>BO'LIMLAR BO'YICHA BATAFSIL NATIJALAR</h3>
        <table class="results-table">
            <thead>
                <tr>
                    <th style="width: 35%;">Bo'lim</th>
                    <th style="width: 20%;">Kategoriya</th>
                    <th style="width: 15%;">Foiz</th>
                    <th style="width: 30%;">Sharh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unitScores as $score)
                    <tr>
                        <td>{{ $score->unit->name }}</td>
                        <td>
                            @if($score->unit->category === 'nikoh')
                                Nikoh
                            @else
                                Ajrim
                            @endif
                        </td>
                        <td class="percentage">{{ number_format($score->match_percentage, 1) }}%</td>
                        <td>{{ $score->interpretation }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Natijalar mavjud emas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Detailed Answers Comparison -->
    <div class="info-section">
        <h3>BATAFSIL JAVOBLAR TAQQOSLASH</h3>
        
        <table class="info-table" style="margin-bottom: 20px;">
            <tr>
                <td class="label">Mos kelgan javoblar:</td>
                <td>{{ count(array_filter($answersComparison, fn($a) => $a['is_match'])) }}</td>
            </tr>
            <tr>
                <td class="label">Zid kelgan javoblar:</td>
                <td>{{ count(array_filter($answersComparison, fn($a) => !$a['is_match'])) }}</td>
            </tr>
            <tr>
                <td class="label">Muhim zid kelgan:</td>
                <td>{{ count(array_filter($answersComparison, fn($a) => $a['is_critical'] && !$a['is_match'])) }}</td>
            </tr>
        </table>
        
        <table class="results-table" style="font-size: 9px;">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Savol</th>
                    <th style="width: 15%;">Bo'lim</th>
                    <th style="width: 10%;">Muhim</th>
                    <th style="width: 10%;">Siz</th>
                    <th style="width: 10%;">Sherik</th>
                    <th style="width: 15%;">Natija</th>
                </tr>
            </thead>
            <tbody>
                @forelse($answersComparison as $index => $answer)
                    <tr style="{{ $answer['is_critical'] && !$answer['is_match'] ? 'background-color: #fef2f2;' : '' }}">
                        <td>{{ $index + 1 }}</td>
                        <td style="font-size: 8px;">{{ Str::limit($answer['question'], 100) }}</td>
                        <td style="font-size: 8px;">{{ $answer['unit_name'] }}</td>
                        <td style="text-align: center;">
                            @if($answer['is_critical'])
                                <strong style="color: #dc2626;">HA</strong>
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($answer['user_answer'])
                                <span style="color: #059669; font-weight: bold;">HA</span>
                            @else
                                <span style="color: #dc2626; font-weight: bold;">YO'Q</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($answer['partner_answer'])
                                <span style="color: #059669; font-weight: bold;">HA</span>
                            @else
                                <span style="color: #dc2626; font-weight: bold;">YO'Q</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($answer['is_match'])
                                <span style="color: #059669; font-weight: bold;">✓ Mos</span>
                            @else
                                <span style="color: #dc2626; font-weight: bold;">✗ Zid</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Javoblar mavjud emas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Disclaimer -->
    <div class="disclaimer">
        <h4>DIQQAT!</h4>
        <p>Ushbu hujjat psixologik test natijalarini aks ettiradi va faqat ma'lumot uchun mo'ljallangan. Bu hujjat davlat muassasalari tomonidan talab qilingan rasmiy hujjat emas. Nikoh yoki ajrim masalalari bo'yicha qaror qabul qilishda professional maslahatchi (psixolog, oilaviy maslahatchi) bilan maslahatlashish tavsiya etiladi.</p>
    </div>
    
    <!-- Signatures -->
    <div class="signatures">
        <div class="signature-box">
            <div class="qr-placeholder">
                QR Kod
            </div>
            <div class="signature-line">
                Hujjat tasdiqlash kodi
            </div>
        </div>
        <div class="signature-box">
            <div class="date-location">
                <p><strong>Sana:</strong> {{ date('d.m.Y') }}</p>
                <p><strong>Joy:</strong> ___________________</p>
            </div>
            <div class="signature-line">
                Ishtirokchi imzosi
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p><strong>Hujjat haqida ma'lumot:</strong></p>
        <p>Ushbu hujjat "Nikoh Testi" axborot tizimi tomonidan avtomatik tarzda yaratilgan.</p>
        <p>Yaratilgan sana: {{ date('d.m.Y H:i:s') }}</p>
        <p>Hujjat ID: {{ uniqid('DOC-', true) }}</p>
        <p style="margin-top: 10px; font-size: 9px; color: #666;">
            © {{ date('Y') }} Nikoh Testi. Barcha huquqlar himoyalangan.
        </p>
    </div>
</body>
</html>
