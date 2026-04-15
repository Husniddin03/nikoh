<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TestSession;
use App\Models\UnitScore;
use App\Models\Unit;
use App\Models\Question;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Placeholder for admin authentication middleware
        // $this->middleware('auth:admin');
    }

    /**
     * Display admin dashboard with statistics
     */
    public function index(): View
    {
        // Basic statistics
        $totalUsers = User::count();
        $totalTests = TestSession::count();
        $completedTests = TestSession::where('status', 'completed')->count();
        $totalUnits = Unit::count();
        $totalQuestions = Question::count();

        // Average compatibility score
        $averageCompatibility = UnitScore::avg('match_percentage');

        // Recent test sessions
        $recentSessions = TestSession::with(['initiator', 'partner'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Tests by category
        $testsByCategory = Unit::withCount('questions')
            ->get()
            ->groupBy('category')
            ->map(function ($units) {
                return [
                    'total_units' => $units->count(),
                    'total_questions' => $units->sum('questions_count'),
                ];
            });

        // Gender distribution
        $genderDistribution = User::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        // Monthly test statistics (last 6 months)
        $monthlyStats = TestSession::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Compatibility ranges
        $compatibilityRanges = [
            'excellent' => UnitScore::where('match_percentage', '>=', 80)->count(),
            'good' => UnitScore::whereBetween('match_percentage', [60, 79.99])->count(),
            'average' => UnitScore::whereBetween('match_percentage', [40, 59.99])->count(),
            'poor' => UnitScore::where('match_percentage', '<', 40)->count(),
        ];

        // Daily test statistics (last 30 days) - for line chart
        $dailyStats = TestSession::selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed, SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress, SUM(CASE WHEN status = "waiting" THEN 1 ELSE 0 END) as waiting')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Test status distribution - for pie chart
        $testStatusDistribution = TestSession::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Age distribution - for bar chart
        $ageGroups = [
            '18-24' => User::whereBetween('jshshir', [50000000000000, 60600000000000])->count(),
            '25-29' => User::whereBetween('jshshir', [30000000000000, 30600000000000])->count() + User::whereBetween('jshshir', [50000000000000, 50600000000000])->count(),
            '30-34' => User::whereBetween('jshshir', [30600000000000, 31200000000000])->count() + User::whereBetween('jshshir', [50600000000000, 51200000000000])->count(),
            '35-39' => User::whereBetween('jshshir', [31200000000000, 31800000000000])->count() + User::whereBetween('jshshir', [51200000000000, 51800000000000])->count(),
            '40+' => User::where(function($q) {
                $q->where('jshshir', '<', 30000000000000)
                  ->orWhere('jshshir', '>=', 60000000000000);
            })->count(),
        ];

        // Unit performance (average match percentage per unit) - for horizontal bar chart
        $unitPerformance = Unit::withAvg('unitScores', 'match_percentage')
            ->orderByDesc('unit_scores_avg_match_percentage')
            ->limit(10)
            ->get()
            ->map(function($unit) {
                return [
                    'name' => $unit->name,
                    'avg_score' => round($unit->unit_scores_avg_match_percentage ?? 0, 1),
                ];
            });

        return view('admin.index', compact(
            'totalUsers',
            'totalTests',
            'completedTests',
            'totalUnits',
            'totalQuestions',
            'averageCompatibility',
            'recentSessions',
            'testsByCategory',
            'genderDistribution',
            'monthlyStats',
            'compatibilityRanges',
            'dailyStats',
            'testStatusDistribution',
            'ageGroups',
            'unitPerformance'
        ));
    }

    /**
     * Get detailed analytics data (AJAX endpoint)
     */
    public function analytics()
    {
        // Unit performance data
        $unitPerformance = Unit::with(['unitScores' => function($query) {
            $query->selectRaw('unit_id, AVG(match_percentage) as avg_score, COUNT(*) as total_tests');
            $query->groupBy('unit_id');
        }])->get();

        // Question difficulty analysis
        $questionAnalysis = Question::with(['results' => function($query) {
            $query->selectRaw('question_id, COUNT(*) as total_answers, AVG(CASE WHEN answer = 1 THEN 1 ELSE 0 END) as agreement_rate');
            $query->groupBy('question_id');
        }])->get();

        return response()->json([
            'unit_performance' => $unitPerformance,
            'question_analysis' => $questionAnalysis,
        ]);
    }

    /**
     * Get chart data with date filtering (AJAX endpoint)
     */
    public function getChartData(Request $request): \Illuminate\Http\JsonResponse
    {
        $chartType = $request->input('chart');
        $period = $request->input('period', '30days');
        $month = $request->input('month');
        $year = $request->input('year', date('Y'));

        switch ($chartType) {
            case 'daily':
                return $this->getDailyStats($period, $month, $year);
            
            case 'status':
                return $this->getStatusDistribution($period, $month, $year);
            
            case 'monthly':
                return $this->getMonthlyStats($period, $year);
            
            case 'compatibility':
                return $this->getCompatibilityRanges($period, $month, $year);
            
            case 'gender':
                return $this->getGenderDistribution();
            
            case 'age':
                return $this->getAgeDistribution();
            
            case 'units':
                return $this->getUnitPerformance($period, $month, $year);
            
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }

    private function getDailyStats($period, $month, $year)
    {
        $query = TestSession::selectRaw('DATE(created_at) as date, COUNT(*) as total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed, SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress, SUM(CASE WHEN status = "waiting" THEN 1 ELSE 0 END) as waiting');
        
        if ($month) {
            $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } else {
            switch ($period) {
                case '7days':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
                case '30days':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case '90days':
                    $query->where('created_at', '>=', now()->subDays(90));
                    break;
                case 'this_year':
                    $query->whereYear('created_at', date('Y'));
                    break;
                default:
                    $query->where('created_at', '>=', now()->subDays(30));
            }
        }
        
        $data = $query->groupBy('date')->orderBy('date')->get();
        
        return response()->json([
            'labels' => $data->pluck('date')->map(fn($d) => date('d.m', strtotime($d))),
            'total' => $data->pluck('total'),
            'completed' => $data->pluck('completed'),
            'in_progress' => $data->pluck('in_progress'),
            'waiting' => $data->pluck('waiting'),
        ]);
    }

    private function getStatusDistribution($period, $month, $year)
    {
        $query = TestSession::selectRaw('status, COUNT(*) as count');
        
        if ($month) {
            $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
        } elseif ($year !== 'all') {
            switch ($period) {
                case 'this_month':
                    $query->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
                    break;
                case 'this_year':
                    $query->whereYear('created_at', date('Y'));
                    break;
                case 'last_year':
                    $query->whereYear('created_at', date('Y') - 1);
                    break;
                case 'all':
                    // No filter
                    break;
            }
        }
        
        $data = $query->groupBy('status')->pluck('count', 'status');
        
        return response()->json([
            'completed' => $data['completed'] ?? 0,
            'in_progress' => $data['in_progress'] ?? 0,
            'waiting' => $data['waiting'] ?? 0,
        ]);
    }

    private function getMonthlyStats($period, $year)
    {
        $query = TestSession::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed');
        
        switch ($period) {
            case '6months':
                $query->where('created_at', '>=', now()->subMonths(6));
                break;
            case '12months':
                $query->where('created_at', '>=', now()->subMonths(12));
                break;
            case 'this_year':
                $query->whereYear('created_at', date('Y'));
                break;
            case 'last_year':
                $query->whereYear('created_at', date('Y') - 1);
                break;
            default:
                $query->where('created_at', '>=', now()->subMonths(6));
        }
        
        $data = $query->groupBy('month')->orderBy('month')->get();
        
        return response()->json([
            'labels' => $data->pluck('month'),
            'total' => $data->pluck('total'),
            'completed' => $data->pluck('completed'),
        ]);
    }

    private function getCompatibilityRanges($period, $month, $year)
    {
        $query = UnitScore::query();
        
        if ($month) {
            $query->whereHas('session', function($q) use ($year, $month) {
                $q->whereYear('created_at', $year)->whereMonth('created_at', $month);
            });
        } elseif ($year !== 'all') {
            $query->whereHas('session', function($q) use ($year) {
                $q->whereYear('created_at', $year);
            });
        }
        
        return response()->json([
            'excellent' => (clone $query)->where('match_percentage', '>=', 80)->count(),
            'good' => (clone $query)->whereBetween('match_percentage', [60, 79.99])->count(),
            'average' => (clone $query)->whereBetween('match_percentage', [40, 59.99])->count(),
            'poor' => (clone $query)->where('match_percentage', '<', 40)->count(),
        ]);
    }

    private function getGenderDistribution()
    {
        $data = User::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender');
        
        return response()->json([
            'male' => $data['male'] ?? 0,
            'female' => $data['female'] ?? 0,
        ]);
    }

    private function getAgeDistribution()
    {
        return response()->json([
            '18-24' => User::whereBetween('jshshir', [50000000000000, 60600000000000])->count(),
            '25-29' => User::whereBetween('jshshir', [30000000000000, 30600000000000])->count() + User::whereBetween('jshshir', [50000000000000, 50600000000000])->count(),
            '30-34' => User::whereBetween('jshshir', [30600000000000, 31200000000000])->count() + User::whereBetween('jshshir', [50600000000000, 51200000000000])->count(),
            '35-39' => User::whereBetween('jshshir', [31200000000000, 31800000000000])->count() + User::whereBetween('jshshir', [51200000000000, 51800000000000])->count(),
            '40+' => User::where(function($q) {
                $q->where('jshshir', '<', 30000000000000)
                  ->orWhere('jshshir', '>=', 60000000000000);
            })->count(),
        ]);
    }

    private function getUnitPerformance($period, $month, $year)
    {
        $query = Unit::withAvg('unitScores', 'match_percentage');
        
        if ($month) {
            $query->whereHas('unitScores.session', function($q) use ($year, $month) {
                $q->whereYear('created_at', $year)->whereMonth('created_at', $month);
            });
        } elseif ($year !== 'all') {
            $query->whereHas('unitScores.session', function($q) use ($year) {
                $q->whereYear('created_at', $year);
            });
        }
        
        $data = $query->orderByDesc('unit_scores_avg_match_percentage')
            ->limit(10)
            ->get()
            ->map(function($unit) {
                return [
                    'name' => $unit->name,
                    'avg_score' => round($unit->unit_scores_avg_match_percentage ?? 0, 1),
                ];
            });
        
        return response()->json([
            'labels' => $data->pluck('name'),
            'scores' => $data->pluck('avg_score'),
        ]);
    }
}
