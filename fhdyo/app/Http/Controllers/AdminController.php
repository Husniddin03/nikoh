<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Couple;
use App\Models\TestResult;
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

        return view('admin.dashboard', compact('totalCouples', 'totalTests', 'completedTests', 'recentTests'));
    }

    public function couples()
    {
        $couples = Couple::with(['testResults' => function($query) {
            $query->latest()->take(1);
        }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.couples.index', compact('couples'));
    }

    public function showCouple(Couple $couple)
    {
        $testResults = $couple->testResults()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.couples.show', compact('couple', 'testResults'));
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
