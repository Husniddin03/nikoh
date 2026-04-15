<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Http\Requests\Admin\UnitRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UnitController extends Controller
{
    public function __construct()
    {
        // Placeholder for admin authentication middleware
        // $this->middleware('auth:admin');
    }

    /**
     * Display a listing of units
     */
    public function index(Request $request): View
    {
        $query = Unit::withCount('questions')
            ->with(['admin']);

        // Filter by search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $units = $query->orderBy('category')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new unit
     */
    public function create(): View
    {
        return view('admin.units.create');
    }

    /**
     * Store a newly created unit
     */
    public function store(UnitRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['admin_id'] = 1; // Placeholder - get from authenticated admin

        Unit::create($data);

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Bo\'lim muvaffaqiyatli yaratildi.');
    }

    /**
     * Display the specified unit
     */
    public function show(Unit $unit): View
    {
        $unit->load(['questions', 'admin', 'unitScores' => function($query) {
            $query->selectRaw('unit_id, AVG(match_percentage) as avg_score, COUNT(*) as total_tests')
                ->groupBy('unit_id');
        }]);

        return view('admin.units.show', compact('unit'));
    }

    /**
     * Show the form for editing the specified unit
     */
    public function edit(Unit $unit): View
    {
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * Update the specified unit
     */
    public function update(UnitRequest $request, Unit $unit): RedirectResponse
    {
        $unit->update($request->validated());

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Bo\'lim muvaffaqiyatli yangilandi.');
    }

    /**
     * Remove the specified unit
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        // Check if unit has questions
        if ($unit->questions()->count() > 0) {
            return redirect()
                ->route('admin.units.index')
                ->with('error', 'Bo\'limni o\'chirish uchun avval uning savollarini o\'chirishingiz kerak.');
        }

        $unit->delete();

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Bo\'lim muvaffaqiyatli o\'chirildi.');
    }

    /**
     * Get units by category (AJAX endpoint)
     */
    public function getByCategory(Request $request)
    {
        $category = $request->input('category');
        
        $units = Unit::where('category', $category)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($units);
    }

    /**
     * Duplicate a unit with its questions
     */
    public function duplicate(Unit $unit): RedirectResponse
    {
        $newUnit = $unit->replicate();
        $newUnit->name = $unit->name . ' (Nusxa)';
        $newUnit->admin_id = 1; // Placeholder - get from authenticated admin
        $newUnit->save();

        // Duplicate questions
        foreach ($unit->questions as $question) {
            $newQuestion = $question->replicate();
            $newQuestion->unit_id = $newUnit->id;
            $newQuestion->admin_id = 1; // Placeholder - get from authenticated admin
            $newQuestion->save();
        }

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Bo\'lim va uning savollari muvaffaqiyatli nusxalandi.');
    }
}
