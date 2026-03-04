@extends('layouts.app')
@section('title', 'Catégories')

@section('content')
<div style="max-width:560px;margin:0 auto;">
    <a href="{{ route('colocations.show', $colocation) }}" style="font-size:13px;color:#6B6560;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:16px;">← {{ $colocation->name }}</a>
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <h1 style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:#1C1C1C;">🏷️ Catégories</h1>
    </div>

    <!-- Add category -->
    <div class="card-elevated" style="padding:24px;margin-bottom:16px;">
        <form method="POST" action="{{ route('categories.store', $colocation) }}" style="display:flex;gap:10px;">
            @csrf
            <input type="text" name="name" class="input" placeholder="Nouvelle catégorie..." required style="flex:1;">
            <button type="submit" class="btn-primary" style="flex-shrink:0;">Ajouter</button>
        </form>
        @if(session('success')) <p style="font-size:13px;color:#1E7E3E;margin-top:10px;">✓ {{ session('success') }}</p> @endif
    </div>

    <!-- List -->
    <div class="card-elevated" style="padding:8px;">
        @forelse($categories as $cat)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;border-bottom:1px solid #F5F0E8;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;background:#F5F0E8;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;">🏷️</div>
                <span style="font-size:14px;font-weight:500;color:#1C1C1C;">{{ $cat->name }}</span>
            </div>
            <form method="POST" action="{{ route('categories.destroy', $cat) }}" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger" style="padding:4px 12px;font-size:12px;">Supprimer</button>
            </form>
        </div>
        @empty
        <div style="text-align:center;padding:40px;color:#B0A89E;font-size:14px;">Aucune catégorie. Créez-en une ci-dessus.</div>
        @endforelse
    </div>
</div>
@endsection