<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colocation;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{


public function index(){

        $user = Auth::user();
        $colocation = $user->activeColocation();
    
    return view('colocations.index',compact('colocation'));
}

public function create(){
  
    return view('colocations.create');
}
    


public function store(Request $request)
{
   $user = auth()->user();

   if($user->hasActiveColocation()){
        return back()->withErrors('Already in a colocation');

   }

   $request->validate([
    'name' => 'required|string|max:255'
   ]);

   $colocation = Colocation::create([
            'name' => $request->name
        ]);
    $colocation->users()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now()
        ]);

        return redirect()->route('colocations.show', $colocation);


    
}

public function show(Colocation $colocation)
    {
        $user = auth()->user();

        // security
        if (!$colocation->users->contains($user)) {
            abort(403);
        }

        $members = $colocation->activeMembers()->get();

        return view('colocations.show', compact('colocation', 'members'));
    }

public function leave(Colocation $colocation)
    {
        $user = auth()->user();

        $membership = $colocation->users()
            ->where('user_id', $user->id)
            ->first();

        if ($membership->pivot->role === 'owner') {
            return back()->withErrors('Owner cannot leave');
        }

        $colocation->users()->updateExistingPivot($user->id, [
            'left_at' => now()
        ]);

        return redirect('/dashboard');
    }

    // cancel
public function cancel(Colocation $colocation)
    {
        $user = auth()->user();

        if ($colocation->owner()->id !== $user->id) {
            abort(403);
        }

        $colocation->update([
            'status' => 'cancelled'
        ]);

        return redirect('/dashboard');
    }
}





