@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
@php $colocation = auth()->user()->activeColocation(); @endphp

<div style="display:flex;flex-direction:column;gap:28px;">

    <!-- Header -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:16px;">
        <div>
            <h1 style="font-family:'Playfair Display',serif;font-size:30px;font-weight:700;color:#1C1C1C;margin-bottom:4px;">
                Bonjour, {{ auth()->user()->name }} 👋
            </h1>
            <p style="font-size:14px;color:#6B6560;">
                @if($colocation)
                    Vous êtes membre de <strong>{{ $colocation->name }}</strong>.
                @else
                    Vous n'avez pas encore de colocation active.
                @endif
            </p>
        </div>
        @if(!$colocation)
        <a href="{{ route('colocations.create') }}" class="btn-primary" style="text-decoration:none;">
            + Créer une colocation
        </a>
        @endif
    </div>

    @if($colocation)
    <!-- Quick access card -->
    <div class="card-elevated" style="padding:28px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;">
        <div style="display:flex;align-items:center;gap:20px;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,#F5C2A0,#C4663A);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:26px;">🏠</div>
            <div>
                <h2 style="font-family:'Playfair Display',serif;font-size:22px;font-weight:700;color:#1C1C1C;margin-bottom:4px;">{{ $colocation->name }}</h2>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span class="badge badge-green">Active</span>
                    <span style="font-size:13px;color:#6B6560;">{{ $colocation->members->count() }} membre(s)</span>
                </div>
            </div>
        </div>
        <a href="{{ route('colocations.show', $colocation) }}" class="btn-primary" style="text-decoration:none;">
            Voir ma colocation →
        </a>
    </div>
    @else
    <!-- Empty state -->
    <div class="card" style="padding:64px 32px;text-align:center;border-style:dashed;border-color:#D4C5B5;">
        <div style="font-size:64px;margin-bottom:20px;">🏡</div>
        <h3 style="font-family:'Playfair Display',serif;font-size:22px;font-weight:600;color:#1C1C1C;margin-bottom:8px;">Aucune colocation active</h3>
        <p style="font-size:14px;color:#6B6560;max-width:360px;margin:0 auto 28px;line-height:1.6;">
            Créez votre première colocation ou attendez une invitation d'un propriétaire.
        </p>
        <a href="{{ route('colocations.create') }}" class="btn-primary" style="text-decoration:none;display:inline-flex;">
            + Créer une colocation
        </a>
    </div>
    @endif
</div>
@endsection