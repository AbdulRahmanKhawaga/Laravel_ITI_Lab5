<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function usersList()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function toggleAdminStatus(User $user)
    {
        // make admin
        if (!$user->is_admin) {
            $user->is_admin = true;
            $user->save();
            return redirect()->route('admin.users.index')
                ->with('success', "User {$user->name} has been granted admin privileges.");
        }

        // remove admin
        $adminCount = User::where('is_admin', true)->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot remove the last admin user.');
        }

        $user->is_admin = false;
        $user->save();
        return redirect()->route('admin.users.index')
            ->with('success', "Admin privileges have been removed from {$user->name}.");
    }
}
