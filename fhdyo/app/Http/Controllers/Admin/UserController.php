<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request): View
    {
        $query = User::with(['initiatorSessions', 'partnerSessions']);

        // Search by JSHSHIR
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('jshshir', 'like', "%{$search}%");
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get total gender counts (not filtered by pagination)
        $totalGenderCounts = User::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        return view('admin.users.index', compact('users', 'totalGenderCounts'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user): View
    {
        $user->load(['initiatorSessions', 'partnerSessions']);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'jshshir' => 'required|string|size:14|unique:users,jshshir,' . $user->id,
            'gender' => 'required|in:male,female',
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Foydalanuvchi muvaffaqiyatli yangilandi.');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user): RedirectResponse
    {
        // Check if user has test sessions
        $totalSessions = $user->initiatorSessions()->count() + $user->partnerSessions()->count();
        if ($totalSessions > 0) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Test sessiyalari bo\'lgan foydalanuvchini o\'chirib bo\'lmaydi.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Foydalanuvchi muvaffaqiyatli o\'chirildi.');
    }
}
