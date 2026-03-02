<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\Colocation;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $user = auth()->user();

      
        if ($colocation->owner()->id !== $user->id) {
            abort(403);
        }

        // validation
        $request->validate([
            'email' => 'required|email'
        ]);

        // generate token
        $token = Str::random(32);

        Invitation::create([
            'email' => $request->email,
            'token' => $token,
            'colocation_id' => $colocation->id
        ]);

        // (optionnel) send email

        return back()->with('success', 'Invitation sent');
    }

    // show invitation page
    public function show($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        return view('invitations.show', compact('invitation'));
    }

    // accept invitation
    public function accept($token)
    {
        $user = auth()->user();

        $invitation = Invitation::where('token', $token)->firstOrFail();

        // check status
        if ($invitation->status !== 'pending') {
            return redirect('/dashboard')->withErrors('Invalid invitation');
        }

        // check email
        if ($invitation->email !== $user->email) {
            return redirect('/dashboard')->withErrors('Wrong user');
        }

        // check active colocation
        if ($user->hasActiveColocation()) {
            return redirect('/dashboard')->withErrors('Already in a colocation');
        }

        // attach user
        $invitation->colocation->users()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now()
        ]);

        // update invitation
        $invitation->update([
            'status' => 'accepted'
        ]);

        return redirect()->route('colocations.show', $invitation->colocation);
    }

    // refuse invitation
    public function refuse($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        $invitation->update([
            'status' => 'refused'
        ]);

        return redirect('/dashboard')->with('success', 'Invitation refused');
    }
}
    
