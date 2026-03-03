<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (! Auth::user()?->is_admin) {
                abort(403, 'Accès réservé aux administrateurs.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $stats = [
            'users'       => User::count(),
            'colocations' => Colocation::count(),
            'active'      => Colocation::where('status', 'active')->count(),
            'expenses'    => Expense::sum('amount'),
            'banned'      => User::where('is_banned', true)->count(),
        ];

        $users       = User::orderBy('created_at', 'desc')->paginate(20);
        $colocations = Colocation::with('owner')->orderBy('created_at', 'desc')->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'users', 'colocations'));
    }

    public function ban(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas vous bannir vous-même.');
        }

        $user->update(['is_banned' => true]);

        return redirect()->back()->with('success', "Utilisateur {$user->name} banni.");
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);

        return redirect()->back()->with('success', "Utilisateur {$user->name} débanni.");
    }
}
