@extends('layouts.app')
@section('title', 'Créer une colocation')

@section('content')
<div style="max-width:560px;margin:0 auto;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('dashboard') }}" style="font-size:13px;color:#6B6560;text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-bottom:16px;">← Retour</a>
        <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:6px;">Créer une colocation 🏡</h1>
        <p style="font-size:14px;color:#6B6560;">Vous serez automatiquement désigné(e) propriétaire.</p>
    </div>

    <div class="card-elevated" style="padding:32px;">
        <form method="POST" action="{{ route('colocations.store') }}" style="display:flex;flex-direction:column;gap:20px;">
            @csrf
            <div>
                <label for="name">Nom de la colocation *</label>
                <input type="text" id="name" name="name" class="input" placeholder="Ex : Appart 3 rue des Lilas" value="{{ old('name') }}" required maxlength="255">
                @error('name') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div style="display:flex;gap:12px;margin-top:8px;">
                <a href="{{ route('dashboard') }}" style="flex:1;text-align:center;border:1px solid #E5DDD0;color:#1C1C1C;border-radius:8px;padding:11px 16px;font-size:14px;font-weight:500;text-decoration:none;transition:background 0.2s;display:block;"
                   onmouseover="this.style.background='#F5F0E8'" onmouseout="this.style.background='transparent'">
                    Annuler
                </a>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">Créer</button>
            </div>
        </form>
    </div>
</div>
@endsection