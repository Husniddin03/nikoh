<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of admins
     */
    public function index(Request $request): View
    {
        $query = Admin::query();

        // Filter by search (name or username)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%');
            });
        }

        // Filter by role (super admin or regular)
        if ($request->filled('role')) {
            if ($request->input('role') === 'super') {
                $query->where('is_super_admin', true);
            } elseif ($request->input('role') === 'admin') {
                $query->where('is_super_admin', false);
            }
        }

        $admins = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.super.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create(): View
    {
        return view('admin.super.admins.create');
    }

    /**
     * Store a newly created admin
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|string|min:8',
            'is_super_admin' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_super_admin'] = $request->boolean('is_super_admin');

        Admin::create($validated);

        return redirect()
            ->route('admin.super.admins.index')
            ->with('success', 'Admin muvaffaqiyatli yaratildi.');
    }

    /**
     * Show the form for editing the specified admin
     */
    public function edit(Admin $admin): View
    {
        return view('admin.super.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin
     */
    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'password' => 'nullable|string|min:8',
            'is_super_admin' => 'boolean',
        ]);

        // Update password only if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_super_admin'] = $request->boolean('is_super_admin');

        // Prevent removing super admin status from yourself
        if ($admin->id === auth('admin')->id() && !$validated['is_super_admin']) {
            return redirect()
                ->back()
                ->with('error', 'O\'zingizni super admin statusidan mahrum qila olmaysiz.');
        }

        $admin->update($validated);

        return redirect()
            ->route('admin.super.admins.index')
            ->with('success', 'Admin muvaffaqiyatli yangilandi.');
    }

    /**
     * Remove the specified admin
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        // Prevent deleting yourself
        if ($admin->id === auth('admin')->id()) {
            return redirect()
                ->route('admin.super.admins.index')
                ->with('error', 'O\'zingizni o\'chirib bo\'lmaydi.');
        }

        $admin->delete();

        return redirect()
            ->route('admin.super.admins.index')
            ->with('success', 'Admin muvaffaqiyatli o\'chirildi.');
    }
}
