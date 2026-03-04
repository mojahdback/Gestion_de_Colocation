@extends('layouts.app')
@section('title', 'Modifier ' . $colocation->name)

@section('content')
<div style="max-width:560px;margin:0 auto;">
    <a href="{{ route('colocations.show', $colocation) }}" style="font-size:13px;color:#6B6560;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;">← Retour</a>
    <div class="card-elevated" style="padding:32px;">
        <h1 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:#1C1C1C;margin-bottom:24px;">✏️ Modifier la colocation</h1>
        <form method="POST" action="{{ route('colocations.update', $colocation) }}" style="display:flex;flex-direction:column;gap:18px;">
            @csrf @method('PATCH')
            <div>
                <label for="name">Nom *</label>
                <input id="name" type="text" name="name" class="input" value="{{ old('name', $colocation->name) }}" required maxlength="255">
                @error('name') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div style="display:flex;gap:12px;margin-top:6px;">
                <a href="{{ route('colocations.show', $colocation) }}" style="flex:1;text-align:center;border:1px solid #E5DDD0;color:#1C1C1C;border-radius:8px;padding:11px;font-size:14px;font-weight:500;text-decoration:none;display:block;">Annuler</a>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection