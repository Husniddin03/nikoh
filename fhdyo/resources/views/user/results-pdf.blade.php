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
            padding: 20px;
            font-size: 11px;
            line-height: 1.5;
            color: #1f2937;
            background-color: #ffffff;
        }
        
        /* Layout Tables */
        .w-full {
            width: 100%;
        }
        .table-layout {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .table-layout td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        /* Header styling */
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            color: #1e1b4b;
            letter-spacing: 0.5px;
        }
        
        .header .subtitle {
            font-size: 12px;
            color: #4b5563;
            font-weight: bold;
        }
        
        /* Official Stamp Section */
        .official-stamp {
            border: 1px dashed #4f46e5;
            padding: 12px;
            margin-bottom: 25px;
            text-align: center;
            background-color: #f5f7ff;
            border-radius: 4px;
        }
        
        .official-stamp h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 5px 0;
            color: #4338ca;
            letter-spacing: 1px;
        }
        .official-stamp p {
            margin: 2px 0;
            color: #4b5563;
        }
        
        /* Section Header */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            background-color: #f3f4f6;
            border-left: 3px solid #4f46e5;
            padding: 6px 10px;
            margin-top: 20px;
            margin-bottom: 12px;
            color: #111827;
            text-transform: uppercase;
        }
        
        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .info-table td {
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        .info-table .label {
            background-color: #f9fafb;
            font-weight: bold;
            width: 40%;
            color: #374151;
        }
        
        /* Score Badge */
        .score-box {
            border: 1px solid #e5e7eb;
            padding: 15px;
            background-color: #fcfcfd;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 25px;
        }
        
        .score-box .score-title {
            font-size: 11px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .score-box .score-value {
            font-size: 36px;
            font-weight: bold;
            color: #4f46e5;
            line-height: 1;
            margin: 5px 0;
        }
        
        .score-box .score-label {
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
            color: #059669;
        }

        /* Data Tables */
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .results-table th {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 8px 10px;
            border: 1px solid #4f46e5;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        .results-table td {
            padding: 7px 10px;
            border: 1px solid #e5e7eb;
            font-size: 11px;
            vertical-align: middle;
        }
        
        .results-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .percentage {
            font-weight: bold;
            color: #059669;
        }
        
        .badge-match {
            color: #059669;
            font-weight: bold;
        }
        
        .badge-mismatch {
            color: #dc2626;
            font-weight: bold;
        }

        .badge-critical {
            color: #ffffff;
            background-color: #dc2626;
            padding: 1px 4px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 2px;
        }
        
        /* Disclaimer */
        .disclaimer {
            border: 1px solid #fef3c7;
            padding: 12px;
            margin: 25px 0;
            background-color: #ffffff;
            border-left: 4px solid #f59e0b;
            border-radius: 4px;
        }
        
        .disclaimer h4 {
            font-weight: bold;
            margin: 0 0 5px 0;
            color: #b45309;
            font-size: 11px;
        }
        .disclaimer p {
            margin: 0;
            color: #6b7280;
            font-size: 10px;
            line-height: 1.4;
        }
        
        /* Signatures Table (Replaced Flexbox) */
        .signatures-table {
            margin-top: 35px;
            width: 100%;
            border-collapse: collapse;
        }
        
        .signature-box {
            text-align: center;
            width: 45%;
        }
        
        .signature-line {
            border-top: 1px solid #9ca3af;
            margin-top: 35px;
            padding-top: 5px;
            font-size: 10px;
            color: #4b5563;
        }
        
        .qr-placeholder {
            border: 1px solid #d1d5db;
            background-color: #f9fafb;
            width: 70px;
            height: 70px;
            margin: 0 auto;
            line-height: 70px;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
        }

        .date-location {
            text-align: right;
            font-size: 11px;
            line-height: 1.4;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
            font-size: 9px;
            color: #9ca3af;
            line-height: 1.4;
        }

        /* Page break controls */
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>O'zbekiston Respublikasi</h1>
        <div class="subtitle">
            {{ $session->category === 'nikoh' ? 'NIKOH MUVOFIQLIGI' : 'AJRIM SABABLARI' }} TESTI NATIJALARI
        </div>
    </div>
    
    <div class="official-stamp">
        <h2>RASMIY HUJJAT</h2>
        <p>Hujjat raqami: NT-{{ $session->id }}-{{ date('Y') }} &nbsp;|&nbsp; Test sanasi: {{ $session->updated_at->format('d.m.Y H:i') }}</p>
    </div>
    
    <div class="section-title">Ishtirokchilar ma'lumotlari</div>
    <table class="info-table">
        <tr>
            <td class="label">Birinchi ishtirokchi (JSHSHIR):</td>
            <td>{{ $currentUser->jshshir }}</td>
            <td class="label">Jinsi:</td>
            <td>{{ $currentUser->gender === 'male' ? 'Erkak' : 'Ayol' }}</td>
        </tr>
        <tr>
            <td class="label">Ikkinchi ishtirokchi (JSHSHIR):</td>
            <td>{{ $partner->jshshir }}</td>
            <td class="label">Jinsi:</td>
            <td>{{ $partner->gender === 'male' ? 'Erkak' : 'Ayol' }}</td>
        </tr>
        <tr>
            <td class="label">Test turi:</td>
            <td>{{ $session->category === 'nikoh' ? 'Nikoh muvofiqligi' : 'Ajrim sabablari' }}</td>
            <td class="label">Savollar soni:</td>
            <td>{{ count($session->question_ids ?? []) }} ta</td>
        </tr>
    </table>
    
    <div class="score-box">
        <div class="score-title">Umumiy muvofiqlik foizi</div>
        <div class="score-value">{{ $overallCompatibility !== null ? number_format($overallCompatibility, 1) : '0.0' }}%</div>
        <div class="score-label">
            @if($overallCompatibility === null)
                <span style="color: #6b7280;">Natijalar mavjud emas</span>
            @elseif($overallCompatibility >= 75)
                <span style="color: #059669;">Yuqori muvofiqlik</span>
            @elseif($overallCompatibility >= 50)
                <span style="color: #d97706;">O'rtacha muvofiqlik</span>
            @else
                <span style="color: #dc2626;">Past muvofiqlik</span>
            @endif
        </div>
    </div>
    
    <div class="section-title">Bo'limlar bo'yicha batafsil natijalar</div>
    <table class="results-table">
        <thead>
            <tr>
                <th style="width: 40%;">Bo'lim nomi</th>
                <th style="width: 15%;">Kategoriya</th>
                <th style="width: 15%;">Muvofiqlik</th>
                <th style="width: 30%;">Sharh / Izoh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unitScores as $score)
                <tr>
                    <td style="font-weight: bold; color: #374151;">{{ $score->unit->name }}</td>
                    <td>{{ $score->unit->category === 'nikoh' ? 'Nikoh' : 'Ajrim' }}</td>
                    <td class="percentage">{{ number_format($score->match_percentage, 1) }}%</td>
                    <td style="color: #4b5563; font-size: 10px;">{{ $score->interpretation }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9ca3af;">Natijalar mavjud emas</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="section-title">Javoblar taqqoslanishi (Statistika)</div>
    <table class="info-table" style="margin-bottom: 20px;">
        <tr>
            <td class="label">Mos kelgan javoblar:</td>
            <td class="badge-match">{{ count(array_filter($answersComparison, fn($a) => $a['is_match'])) }} ta</td>
            <td class="label">Zid kelgan javoblar:</td>
            <td class="badge-mismatch">{{ count(array_filter($answersComparison, fn($a) => !$a['is_match'])) }} ta</td>
            <td class="label">Muhim (Kritik) zidliklar:</td>
            <td><span class="badge-critical" style="background-color: {{ count(array_filter($answersComparison, fn($a) => $a['is_critical'] && !$a['is_match'])) > 0 ? '#dc2626' : '#9ca3af' }}">{{ count(array_filter($answersComparison, fn($a) => $a['is_critical'] && !$a['is_match'])) }} ta</span></td>
        </tr>
    </table>
    
    <div class="section-title">Savollar kesimida batafsil tahlil</div>
    <table class="results-table" style="font-size: 10px;">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">#</th>
                <th style="width: 50%;">Savol matni</th>
                <th style="width: 18%;">Bo'lim</th>
                <th style="width: 8%; text-align: center;">Muhim</th>
                <th style="width: 10%; text-align: center;">Natija</th>
            </tr>
        </thead>
        <tbody>
            @forelse($answersComparison as $index => $answer)
                <tr style="{{ $answer['is_critical'] && !$answer['is_match'] ? 'background-color: #fef2f2;' : '' }}">
                    <td style="text-align: center; color: #6b7280;">{{ $index + 1 }}</td>
                    <td style="font-weight: 500;">{{ Str::limit($answer['question'], 120) }}</td>
                    <td style="color: #6b7280; font-size: 9px;">{{ $answer['unit_name'] }}</td>
                    <td style="text-align: center;">
                        @if($answer['is_critical'])
                            <span class="badge-critical">HA</span>
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($answer['is_match'])
                            <span class="badge-match">✓ Mos</span>
                        @else
                            <span class="badge-mismatch">✗ Zid</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #9ca3af;">Javoblar mavjud emas</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="disclaimer">
        <h4>DIQQAT! MUHIM ESLATMA</h4>
        <p>Ushbu hujjat psixologik test natijalarini avtomatik tahlil asosida aks ettiradi va faqat tavsiyaviy xarakterga ega. Ushbu hisobot davlat organlari yoki sud idoralari tomonidan talab qilinadigan yuridik kuchga ega rasmiy hujjat hisoblanmaydi. Yakuniy oilaviy qarorlarni qabul qilishda malakali oilaviy psixolog yoki mutaxassis bilan bevosita maslahatlashish tavsiya etiladi.</p>
    </div>
    
    <table class="table-layout signatures-table">
        <tr>
            <td class="signature-box" style="width: 45%;">
                <div class="qr-placeholder">QR KOD</div>
                <div class="signature-line">Hujjatni tasdiqlash kodi</div>
            </td>
            <td style="width: 10%;">&nbsp;</td>
            <td class="signature-box" style="width: 45%;">
                <div class="date-location">
                    <p><strong>Sana:</strong> {{ date('d.m.Y') }}</p>
                    <p><strong>Joy:</strong> Toshkent sh.</p>
                </div>
                <div class="signature-line">Ishtirokchining imzosi</div>
            </td>
        </tr>
    </table>
    
    <div class="footer">
        <p><strong>Hujjat haqida ma'lumot:</strong></p>
        <p>Ushbu elektron hisobot "Nikoh Testi" axborot tizimi platformasida generatsiya qilingan.</p>
        <p>Yaratilgan vaqti: {{ date('d.m.Y H:i:s') }} &nbsp;|&nbsp; Hujjat tizimli ID raqami: {{ uniqid('DOC-', false) }}</p>
        <p style="margin-top: 5px; font-size: 8px; color: #9ca3af;">
            © {{ date('Y') }} Nikoh Testi axborot tizimi. Barcha huquqlar himoyalangan.
        </p>
    </div>
</body>
</html>