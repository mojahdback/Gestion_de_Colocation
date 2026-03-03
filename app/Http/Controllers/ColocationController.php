<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
   
    public function index()
    {
        $user = Auth::user();

        $colocations = Colocation::whereHas('members', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();

        return view('colocations.index', compact('colocations'));
    }

   
    public function create()
    {
        return view('colocations.create');
    }

    /**
     * Store new colocation
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = Auth::user();

      
        if ($user->membership) {
            return back()->with('error', 'Tu es déjà dans une colocation');
        }

        $colocation = Colocation::create([
            'name' => $request->name,
            'status' => 'active'
        ]);

    
        Membership::create([
            'user_id' => $user->id,
            'colocation_id' => $colocation->id,
            'role' => 'owner'
        ]);

        return redirect()->route('colocations.show', $colocation);
    }

   
    public function show(Colocation $colocation)
    {
        $colocation->load(['members', 'expenses', 'categories']);

        $members = $colocation->members;
        $expenses = $colocation->expenses;
        $categories = $colocation->categories; 

       

        $balances = [];

        foreach ($members as $member) {
            $balances[$member->id] = 0;
        }

        foreach ($expenses as $expense) {

            $amount = $expense->amount;
            $membersCount = $members->count();

            if ($membersCount == 0) continue;

            $share = $amount / $membersCount;

            foreach ($members as $member) {

                if ($member->id == $expense->payer_id) {
                    $balances[$member->id] += ($amount - $share);
                } else {
                    $balances[$member->id] -= $share;
                }

            }
        }

    

        $creditors = [];
        $debtors = [];

        foreach ($balances as $userId => $balance) {

            if ($balance > 0) {
                $creditors[] = [
                    'user_id' => $userId,
                    'amount' => $balance
                ];
            }

            if ($balance < 0) {
                $debtors[] = [
                    'user_id' => $userId,
                    'amount' => abs($balance)
                ];
            }
        }


        $settlements = [];

        while (!empty($creditors) && !empty($debtors)) {

            $creditor = &$creditors[0];
            $debtor = &$debtors[0];

            $amount = min($creditor['amount'], $debtor['amount']);

            $fromUser = $members->find($debtor['user_id']);
            $toUser = $members->find($creditor['user_id']);

            $settlements[] = [
                'from' => $fromUser->name,
                'to' => $toUser->name,
                'amount' => round($amount, 2)
            ];

            $creditor['amount'] -= $amount;
            $debtor['amount'] -= $amount;

            if ($creditor['amount'] <= 0.01) {
                array_shift($creditors);
            }

            if ($debtor['amount'] <= 0.01) {
                array_shift($debtors);
            }
        }

        return view('colocations.show', compact(
            'colocation',
            'members',
            'expenses',
            'categories',
            'balances',
            'settlements'
        ));
    }

   
    public function leave(Colocation $colocation)
    {
        $user = Auth::user();

        $membership = Membership::where('user_id', $user->id)
            ->where('colocation_id', $colocation->id)
            ->first();

        if (!$membership) {
            abort(403);
        }

       
        if ($membership->role === 'owner') {
            return back()->with('error', 'Owner cannot leave');
        }

        $membership->delete();

        return redirect('/')->with('success', 'Tu as quitté la colocation');
    }

  
    public function removeMember(Colocation $colocation, $userId)
    {
        $authUser = Auth::user();

        $owner = Membership::where('colocation_id', $colocation->id)
            ->where('user_id', $authUser->id)
            ->where('role', 'owner')
            ->first();

        if (!$owner) {
            abort(403);
        }

        Membership::where('colocation_id', $colocation->id)
            ->where('user_id', $userId)
            ->delete();

        return back()->with('success', 'Member removed');
    }

  
    public function cancel(Colocation $colocation)
    {
        $user = Auth::user();

        $membership = Membership::where('user_id', $user->id)
            ->where('colocation_id', $colocation->id)
            ->where('role', 'owner')
            ->first();

        if (!$membership) {
            abort(403);
        }

        $colocation->update([
            'status' => 'cancelled'
        ]);

        return redirect('/')->with('success', 'Colocation cancelled');
    }
}