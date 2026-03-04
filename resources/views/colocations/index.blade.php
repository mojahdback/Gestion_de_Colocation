@extends('layouts.app')
@section('title', 'Mes Colocations')

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">
    <div style="display:flex;align-items:center;justify-content:space-between;">
        <div>
            <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:4px;">Mes Colocations</h1>
            <p style="font-size:14px;color:#6B6560;">{{ $colocations->count() }} colocation(s) trouvée(s)</p>
        </div>
        <a href="{{ route('colocations.create') }}" class="btn-primary" style="text-decoration:none;">+ Créer</a>
    </div>

    @forelse($colocations as $colocation)
    <div class="card-elevated" style="padding:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
        <div style="display:flex;align-items:center;gap:16px;">
            <div style="width:50px;height:50px;background:linear-gradient(135deg,#F5C2A0,#C4663A);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:24px;">🏠</div>
            <div>
                <h2 style="font-size:18px;font-weight:600;color:#1C1C1C;margin-bottom:5px;">{{ $colocation->name }}</h2>
                <div style="display:flex;align-items:center;gap:8px;">
                    <span class="badge {{ $colocation->status === 'active' ? 'badge-green' : 'badge-gray' }}">{{ $colocation->status }}</span>
                    <span style="font-size:13px;color:#6B6560;">{{ $colocation->members->count() }} membre(s)</span>
                </div>
            </div>
        </div>
        <a href="{{ route('colocations.show', $colocation) }}" class="btn-primary" style="text-decoration:none;">Voir →</a>
    </div>
    @empty
    <div class="card" style="padding:64px 32px;text-align:center;border-style:dashed;border-color:#D4C5B5;">
        <div style="font-size:60px;margin-bottom:16px;">🏡</div>
        <h3 style="font-family:'Playfair Display',serif;font-size:20px;font-weight:600;color:#1C1C1C;margin-bottom:8px;">Aucune colocation</h3>
        <p style="font-size:14px;color:#6B6560;margin-bottom:24px;">Créez votre première colocation ou attendez une invitation.</p>
        <a href="{{ route('colocations.create') }}" class="btn-primary" style="text-decoration:none;display:inline-flex;">+ Créer une colocation</a>
    </div>
    @endforelse
</div>
@endsection