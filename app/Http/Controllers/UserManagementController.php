<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('dashboard.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        // Prevent modifying superadmins
        if ($user->role === 'superadmin') {
            return back()->with('error', __('Vous ne pouvez pas modifier le rôle d\'un superadmin.'));
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', __('Le rôle de l\'utilisateur a été mis à jour avec succès.'));
    }
}
