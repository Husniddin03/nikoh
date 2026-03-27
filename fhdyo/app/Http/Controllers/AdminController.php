<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PDFService;
use App\Models\TestResult;
use App\Models\Couple;
use App\Models\SurveySection;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalCouples = Couple::count();
        $totalTests = TestResult::count();
        $completedTests = TestResult::where('status', 'completed')->count();
        $recentTests = TestResult::with('couple')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Kunlik statistika: bo'sh kunlarni ham 0 bilan to'ldirish uchun yaxshilangan variant
        $dailyStats = TestResult::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Oylik statistika
        $monthlyStats = TestResult::selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('month')
            ->orderByRaw('MIN(created_at)') // Oylarni tartib bilan chiqarish uchun
            ->get();

        // Haftalik statistika
        $weeklyStats = TestResult::selectRaw('YEARWEEK(created_at) as week, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(3))
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Bo'limlar bo'yicha statistika
        $sectionStats = [];
        $sections = SurveySection::with(['questions.answers' => function($query) {
            $query->whereHas('testResult', function($q) {
                $q->where('status', 'completed');
            });
        }])->get();

        foreach ($sections as $section) {
            $totalAnswers = 0;
            $totalScore = 0;
            
            foreach ($section->questions as $question) {
                foreach ($question->answers as $answer) {
                    $totalAnswers++;
                    $totalScore += $answer->score;
                }
            }
            
            $sectionStats[] = [
                'title' => $section->title,
                'total_answers' => $totalAnswers,
                'avg_score' => $totalAnswers > 0 ? round(($totalScore / ($totalAnswers * 2)) * 100, 1) : 0
            ];
        }

        // Moslik darajasi bo'yicha statistika
        $compatibilityStats = [
            'juda_yuqori' => 0,
            'yuqori' => 0,
            'o\'rtacha' => 0,
            'past' => 0
        ];

        $completedTestResults = TestResult::where('status', 'completed')->get();
        foreach ($completedTestResults as $test) {
            $percentage = ($test->total_score / $test->max_score) * 100;
            
            if ($percentage >= 80) {
                $compatibilityStats['juda_yuqori']++;
            } elseif ($percentage >= 60) {
                $compatibilityStats['yuqori']++;
            } elseif ($percentage >= 40) {
                $compatibilityStats['o\'rtacha']++;
            } else {
                $compatibilityStats['past']++;
            }
        }

        return view('admin.dashboard', compact(
            'totalCouples', 
            'totalTests', 
            'completedTests', 
            'recentTests',
            'dailyStats',
            'weeklyStats',
            'monthlyStats',
            'sectionStats',
            'compatibilityStats'
        ));
    }

    public function couples()
    {
        // Get unique couples with their latest test using database grouping
        $coupleIds = TestResult::selectRaw('MIN(id) as id, couple_id')
            ->groupBy('couple_id')
            ->orderByRaw('MIN(created_at) DESC')
            ->pluck('couple_id');

        // Get couples with their test results (optimized)
        $couples = Couple::whereIn('id', $coupleIds)
            ->with(['testResults' => function($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.couples.index', compact('couples'));
    }

    public function showCouple($coupleId)
    {
        // Find all tests for this couple
        $allTests = TestResult::with(['couple', 'answers.question.surveySection'])
            ->whereHas('couple', function($query) use ($coupleId) {
                $query->where('id', $coupleId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($allTests->isEmpty()) {
            abort(404);
        }

        // Group tests by couple
        $coupleData = [
            'couple' => $allTests->first()->couple,
            'test_results' => $allTests
        ];

        return view('admin.couples.details', compact('coupleData'));
    }

    public function getChartData(Request $request)
    {
        $type = $request->get('type'); // 'daily' yoki 'monthly'
        $date = $request->get('date'); // '2024-03-27' yoki '2024-03'

        if ($type === 'daily') {
            // Tanlangan kundan orqaga 30 kunlik ma'lumot
            $data = TestResult::selectRaw('DATE(created_at) as label, COUNT(*) as count')
                ->where('created_at', '<=', $date . ' 23:59:59')
                ->where('created_at', '>=', \Carbon\Carbon::parse($date)->subDays(30))
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        } else {
            // Tanlangan yil va oy uchun ma'lumot
            $yearMonth = explode('-', $date);
            $year = $yearMonth[0];
            $month = $yearMonth[1];
            
            $data = TestResult::selectRaw('DATE(created_at) as label, COUNT(*) as count')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        }

        return response()->json($data);
    }

    public function getSectionStats(Request $request)
    {
        $date = $request->get('date'); // '2024-03'
        $yearMonth = explode('-', $date);
        $year = $yearMonth[0];
        $month = $yearMonth[1];
        
        // Bo'limlar bo'yicha statistika
        $sectionStats = [];
        $sections = SurveySection::with(['questions.answers' => function($query) use ($year, $month) {
            $query->whereHas('testResult', function($q) use ($year, $month) {
                $q->where('status', 'completed')
                  ->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
            });
        }])->get();

        foreach ($sections as $section) {
            $totalAnswers = 0;
            $totalScore = 0;
            
            foreach ($section->questions as $question) {
                foreach ($question->answers as $answer) {
                    $totalAnswers++;
                    $totalScore += $answer->score;
                }
            }
            
            $sectionStats[] = [
                'title' => $section->title,
                'total_answers' => $totalAnswers,
                'avg_score' => $totalAnswers > 0 ? round(($totalScore / ($totalAnswers * 2)) * 100, 1) : 0
            ];
        }

        return response()->json($sectionStats);
    }

    public function getCompatibilityStats(Request $request)
    {
        $date = $request->get('date'); // '2024-03'
        $yearMonth = explode('-', $date);
        $year = $yearMonth[0];
        $month = $yearMonth[1];

        // Moslik darajasi bo'yicha statistika
        $compatibilityStats = [
            'juda_yuqori' => 0,
            'yuqori' => 0,
            'o\'rtacha' => 0,
            'past' => 0
        ];

        $completedTestResults = TestResult::where('status', 'completed')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->get();
            
        foreach ($completedTestResults as $test) {
            $percentage = ($test->total_score / $test->max_score) * 100;
            
            if ($percentage >= 80) {
                $compatibilityStats['juda_yuqori']++;
            } elseif ($percentage >= 60) {
                $compatibilityStats['yuqori']++;
            } elseif ($percentage >= 40) {
                $compatibilityStats['o\'rtacha']++;
            } else {
                $compatibilityStats['past']++;
            }
        }

        return response()->json($compatibilityStats);
    }

    public function cleanupTempFile($filename)
    {
        $path = storage_path('app/temp/' . $filename);
        if (file_exists($path)) {
            unlink($path);
        }
        return response()->json(['success' => true]);
    }

    public function downloadTestResultPDF($testResultId)
    {
        $testResult = TestResult::with(['couple', 'answers.question.surveySection'])
            ->findOrFail($testResultId);
            
        $pdfService = new PDFService();
        return $pdfService->downloadTestResultPDF($testResult);
    }
    
    public function printTestResult($testResultId)
    {
        $testResult = TestResult::with(['couple', 'answers.question.surveySection'])
            ->findOrFail($testResultId);
            
        // Generate PDF directly without saving to temp
        $pdfService = new PDFService();
        $pdf = $pdfService->generateTestResultPDF($testResult);
        
        // Save PDF temporarily with proper path
        $filename = 'temp-test-result-' . $testResultId . '.pdf';
        $tempPath = storage_path('app/temp/' . $filename);
        $publicPath = 'storage/temp/' . $filename;
        
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }
        
        file_put_contents($tempPath, $pdf->output());
        
        return view('admin.results.print', compact('testResult', 'filename'));
    }

    public function results()
    {
        $testResults = TestResult::with('couple')
            ->where('status', 'completed')
            ->orderBy('completed_at', 'desc')
            ->paginate(10);

        return view('admin.results.index', compact('testResults'));
    }
}
