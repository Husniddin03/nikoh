<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestSession;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class TestSessionController extends Controller
{
    /**
     * Display a listing of test sessions
     */
    public function index(Request $request): View
    {
        $query = TestSession::with(['initiator', 'partner', 'results']);

        // Search by JSHSHIR
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('initiator', function($q) use ($search) {
                $q->where('jshshir', 'like', "%{$search}%");
            })->orWhereHas('partner', function($q) use ($search) {
                $q->where('jshshir', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $sessions = $query->orderBy('created_at', 'desc')->paginate(20);

        // Status counts for legend (using groupBy for accuracy)
        $statusCounts = TestSession::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.test-sessions.index', compact('sessions', 'statusCounts'));
    }

    /**
     * Show the form for creating a new test session
     */
    public function create(): View
    {
        $users = User::orderBy('jshshir')->get();
        return view('admin.test-sessions.create', compact('users'));
    }

    /**
     * Store a newly created test session
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'initiator_id' => 'required|exists:users,id',
            'partner_id' => 'required|exists:users,id|different:initiator_id',
        ]);

        $validated['status'] = 'waiting';
        $validated['access_code'] = strtoupper(substr(md5(uniqid()), 0, 8));

        TestSession::create($validated);

        return redirect()
            ->route('admin.test-sessions.index')
            ->with('success', 'Juftlik muvaffaqiyatli yaratildi.');
    }

    /**
     * Display the specified test session
     */
    public function show(TestSession $testSession): View
    {
        $testSession->load(['initiator', 'partner', 'results.question.unit']);
        
        // Calculate compatibility
        $totalQuestions = $testSession->results->count() / 2; // Each question answered by both users
        $initiatorResults = $testSession->results->where('user_id', $testSession->initiator_id);
        $partnerResults = $testSession->results->where('user_id', $testSession->partner_id);
        
        // Calculate matched answers (both answered yes)
        $matchedAnswers = 0;
        foreach ($initiatorResults as $initResult) {
            $partnerResult = $partnerResults->firstWhere('question_id', $initResult->question_id);
            if ($partnerResult && $initResult->answer && $partnerResult->answer) {
                $matchedAnswers++;
            }
        }
        
        $compatibility = $initiatorResults->count() > 0 
            ? round(($matchedAnswers / $initiatorResults->count()) * 100, 1) 
            : 0;
        
        // Get answers comparison for each question
        $answersComparison = [];
        $questionIds = $testSession->results->pluck('question_id')->unique();
        
        foreach ($questionIds as $questionId) {
            $initiatorAnswer = $initiatorResults->firstWhere('question_id', $questionId);
            $partnerAnswer = $partnerResults->firstWhere('question_id', $questionId);
            $question = $initiatorAnswer?->question ?? $partnerAnswer?->question;
            
            if ($question) {
                $answersComparison[] = [
                    'question' => $question,
                    'unit_name' => $question->unit?->name ?? 'Noma\'lum',
                    'initiator_answer' => $initiatorAnswer?->answer ?? null,
                    'partner_answer' => $partnerAnswer?->answer ?? null,
                    'matched' => $initiatorAnswer?->answer && $partnerAnswer?->answer,
                ];
            }
        }
        
        // Group by unit for better display
        $groupedAnswers = collect($answersComparison)->groupBy('unit_name');
        
        return view('admin.test-sessions.show', compact(
            'testSession', 
            'compatibility', 
            'answersComparison',
            'groupedAnswers',
            'initiatorResults',
            'partnerResults'
        ));
    }

    /**
     * Remove the specified test session
     */
    public function destroy(TestSession $testSession): RedirectResponse
    {
        $testSession->delete();

        return redirect()
            ->route('admin.test-sessions.index')
            ->with('success', 'Juftlik muvaffaqiyatli o\'chirildi.');
    }

    /**
     * Download test session results as PDF
     */
    public function downloadPdf(TestSession $testSession): Response
    {
        $testSession->load(['initiator', 'partner', 'results.question.unit']);
        
        // Calculate compatibility
        $totalQuestions = $testSession->results->count() / 2;
        $initiatorResults = $testSession->results->where('user_id', $testSession->initiator_id);
        $partnerResults = $testSession->results->where('user_id', $testSession->partner_id);
        
        $matchedAnswers = 0;
        foreach ($initiatorResults as $initResult) {
            $partnerResult = $partnerResults->firstWhere('question_id', $initResult->question_id);
            if ($partnerResult && $initResult->answer && $partnerResult->answer) {
                $matchedAnswers++;
            }
        }
        
        $compatibility = $initiatorResults->count() > 0 
            ? round(($matchedAnswers / $initiatorResults->count()) * 100, 1) 
            : 0;
        
        // Get answers comparison
        $answersComparison = [];
        $questionIds = $testSession->results->pluck('question_id')->unique();
        
        foreach ($questionIds as $questionId) {
            $initiatorAnswer = $initiatorResults->firstWhere('question_id', $questionId);
            $partnerAnswer = $partnerResults->firstWhere('question_id', $questionId);
            $question = $initiatorAnswer?->question ?? $partnerAnswer?->question;
            
            if ($question) {
                $answersComparison[] = [
                    'question' => $question,
                    'unit_name' => $question->unit?->name ?? 'Noma\'lum',
                    'initiator_answer' => $initiatorAnswer?->answer ?? null,
                    'partner_answer' => $partnerAnswer?->answer ?? null,
                    'matched' => $initiatorAnswer?->answer && $partnerAnswer?->answer,
                ];
            }
        }
        
        $groupedAnswers = collect($answersComparison)->groupBy('unit_name');
        
        // Generate PDF
        $pdf = Pdf::loadView('admin.test-sessions.pdf', compact(
            'testSession',
            'compatibility',
            'answersComparison',
            'groupedAnswers',
            'initiatorResults',
            'partnerResults',
            'matchedAnswers'
        ));
        
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'defaultFont' => 'DejaVu Sans',
            'isRemoteEnabled' => false,
            'isHtml5ParserEnabled' => true,
        ]);
        
        $fileName = 'nikoh_test_natijalari_' . $testSession->id . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($fileName);
    }
}
