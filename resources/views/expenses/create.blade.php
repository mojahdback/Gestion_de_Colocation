@extends('layouts.app')
@section('title', 'Ajouter une dépense')

@section('content')
<div style="max-width:560px;margin:0 auto;">
    <a href="{{ route('colocations.show', $colocation) }}" style="font-size:13px;color:#6B6560;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;">← Retour</a>
    <div class="card-elevated" style="padding:32px;">
        <h1 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:#1C1C1C;margin-bottom:24px;">Ajouter une dépense</h1>
        <form method="POST" action="{{ route('expenses.store', $colocation) }}" style="display:flex;flex-direction:column;gap:16px;">
            @csrf
            <div>
                <label>Titre *</label>
                <input type="text" name="title" class="input" placeholder="Ex: Courses Aldi" required>
                @error('title') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div>
                    <label>Montant (€) *</label>
                    <input type="number" name="amount" class="input" step="0.01" min="0.01" placeholder="0.00" required>
                    @error('amount') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label>Date *</label>
                    <input type="date" name="date" class="input" value="{{ date('Y-m-d') }}" required>
                    @error('date') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label>Payé par *</label>
                <select name="payer_id" class="input" required>
                    @foreach($members as $m)
                    <option value="{{ $m->id }}" {{ $m->id === auth()->id() ? 'selected' : '' }}>{{ $m->name }}</option>
                    @endforeach
                </select>
                @error('payer_id') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Catégorie *</label>
                <select name="category_id" class="input" required>
                    <option value="">— Choisir —</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div style="display:flex;gap:12px;margin-top:8px;">
                <a href="{{ route('colocations.show', $colocation) }}" style="flex:1;text-align:center;border:1px solid #E5DDD0;color:#1C1C1C;border-radius:8px;padding:11px;font-size:14px;font-weight:500;text-decoration:none;display:block;">Annuler</a>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">Ajouter</button>
            </div>
        </form>
    </div>
</div>
@endsection