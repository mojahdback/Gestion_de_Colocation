@extends('layouts.app')
@section('title', 'Invitation')

@section('content')
<div style="max-width:480px;margin:40px auto;">
    <div class="card-elevated" style="padding:40px;text-align:center;">
        <div style="font-size:60px;margin-bottom:20px;">📬</div>
        <h1 style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:#1C1C1C;margin-bottom:6px;">Invitation</h1>
        <p style="font-size:16px;color:#C4663A;font-weight:600;margin-bottom:24px;">{{ $invitation->colocation->name }}</p>

        @if($invitation->status !== 'pending')
        <div style="background:#FFF0EE;border:1px solid #F5C2BA;color:#C0392B;padding:14px 18px;border-radius:10px;font-size:14px;margin-bottom:16px;">
            Cette invitation n'est plus valide
            ({{ $invitation->status === 'accepted' ? 'déjà acceptée' : 'refusée' }}).
        </div>
        <a href="{{ route('dashboard') }}" class="btn-primary" style="text-decoration:none;display:inline-flex;">Retour au dashboard</a>

        @elseif(auth()->user()->email !== $invitation->email)
        <div style="background:#FFFBEB;border:1px solid #FDE68A;color:#92400E;padding:14px 18px;border-radius:10px;font-size:14px;margin-bottom:16px;">
            ⚠️ Cette invitation est pour <strong>{{ $invitation->email }}</strong>.<br>
            Vous êtes connecté(e) avec <strong>{{ auth()->user()->email }}</strong>.
        </div>

        @elseif(auth()->user()->hasActiveColocation())
        <div style="background:#FFF3E0;border:1px solid #FFCC80;color:#E65100;padding:14px 18px;border-radius:10px;font-size:14px;margin-bottom:16px;">
            ⚠️ Vous faites déjà partie d'une colocation active.
        </div>

        @else
        <p style="font-size:14px;color:#6B6560;margin-bottom:28px;">
            Invitation pour <strong>{{ $invitation->email }}</strong>.
        </p>
        <div style="display:flex;gap:12px;">
            <form method="POST" action="{{ route('invitations.refuse', $invitation->token) }}" style="flex:1;">
                @csrf
                <button type="submit" style="width:100%;border:1px solid #E5DDD0;background:transparent;border-radius:8px;padding:12px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;color:#6B6560;cursor:pointer;">
                    Refuser
                </button>
            </form>
            <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}" style="flex:1;">
                @csrf
                <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">Accepter 🎉</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
