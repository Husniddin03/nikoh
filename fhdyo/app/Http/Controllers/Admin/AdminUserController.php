<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->orWhere('role', 'super_admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,super_admin'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin muvaffaqiyatli qo\'shildi');
    }

    public function edit(User $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'role' => 'required|in:admin,super_admin'
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6|confirmed'
            ]);
            $admin->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin ma\'lumotlari muvaffaqiyatli yangilandi');
    }

    public function destroy(User $admin)
    {
        // Prevent deleting the current logged-in admin
        if (auth()->id() === $admin->id) {
            return back()->with('error', 'O\'z o\'zingizni o\'chira olmaysiz');
        }

        // Check if this is the last admin
        $adminCount = User::where('role', 'admin')
            ->orWhere('role', 'super_admin')
            ->count();

        if ($adminCount <= 1) {
            return back()->with('error', 'Tizimda kamida bitta admin bo\'lishi kerak');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin muvaffaqiyatli o\'chirildi');
    }

    public function toggleStatus(User $admin)
    {
        // Prevent deactivating the current logged-in admin
        if (auth()->id() === $admin->id) {
            return back()->with('error', 'O\'z o\'zingizni holatini o\'zgartira olmaysiz');
        }

        // Toggle between admin and regular user
        if ($admin->role === 'admin' || $admin->role === 'super_admin') {
            $admin->update(['role' => 'user']);
            $message = 'Admin huquqlari olib tashlandi';
        } else {
            $admin->update(['role' => 'admin']);
            $message = 'Admin huquqlari berildi';
        }

        return back()->with('success', $message);
    }
}
