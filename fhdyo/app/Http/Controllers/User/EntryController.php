<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserEntryRequest;
use App\Services\JshshirService;
use App\Models\TestSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EntryController extends Controller
{
    protected JshshirService $jshshirService;

    public function __construct(JshshirService $jshshirService)
    {
        $this->jshshirService = $jshshirService;
    }

    /**
     * Show the entry form
     */
    public function index(): View
    {
        return view('user.entry');
    }

    /**
     * Store the user entry and create test session
     */
    public function store(UserEntryRequest $request): RedirectResponse
    {
        $myJshshir = $request->validated()['my_jshshir'];
        $partnerJshshir = $request->validated()['partner_jshshir'];

        // Get or create users
        $initiator = $this->jshshirService->getOrCreateUser($myJshshir);
        $partner = $this->jshshirService->getOrCreateUser($partnerJshshir);

        // Check if session already exists
        $existingSession = TestSession::where(function ($query) use ($initiator, $partner) {
            $query->where('initiator_id', $initiator->id)
                  ->where('partner_id', $partner->id);
        })->orWhere(function ($query) use ($initiator, $partner) {
            $query->where('initiator_id', $partner->id)
                  ->where('partner_id', $initiator->id);
        })->first();

        if ($existingSession) {
            return redirect()->route('test.show', $existingSession->id)
                ->with('info', 'Sizning test sessiyangiz allaqachon mavjud.');
        }

        // Create new test session
        $testSession = $this->jshshirService->createTestSession($initiator, $partner);

        return redirect()->route('test.show', $testSession->id)
            ->with('success', 'Test sessiyasi muvaffaqiyatli yaratildi.');
    }
}
