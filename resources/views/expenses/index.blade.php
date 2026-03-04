@extends('layouts.app')
@section('title', 'Dépenses — ' . $colocation->name)

@section('content')
<div style="display:flex;flex-direction:column;gap:20px;">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <a href="{{ route('colocations.show', $colocation) }}" style="font-size:13px;color:#6B6560;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:8px;">← {{ $colocation->name }}</a>
            <h1 style="font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:#1C1C1C;">Dépenses</h1>
        </div>
        <a href="{{ route('expenses.create', $colocation) }}" class="btn-primary" style="text-decoration:none;">+ Ajouter</a>
    </div>

    <div class="card-elevated" style="padding:24px;">
        @if($expenses->isEmpty())
        <div style="text-align:center;padding:48px 0;">
            <div style="font-size:48px;margin-bottom:14px;">💰</div>
            <p style="font-size:15px;color:#B0A89E;">Aucune dépense enregistrée.</p>
        </div>
        @else
        <div style="display:flex;flex-direction:column;gap:8px;">
            @foreach($expenses as $expense)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:#F5F0E8;border-radius:10px;">
                <div style="display:flex;align-items:center;gap:12px;">
                    <div style="width:38px;height:38px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;border:1px solid #E5DDD0;">💳</div>
                    <div>
                        <p style="font-size:14px;font-weight:500;color:#1C1C1C;">{{ $expense->title }}</p>
                        <p style="font-size:12px;color:#6B6560;margin-top:2px;">
                            {{ optional($expense->payer)->name }} • {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}
                            @if($expense->category) • {{ $expense->category->name }} @endif
                        </p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:14px;">
                    <span style="font-size:16px;font-weight:700;color:#1C1C1C;">{{ number_format($expense->amount, 2) }} €</span>
                    <form method="POST" action="{{ route('expenses.destroy', $expense) }}" onsubmit="return confirm('Supprimer ?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#D4C5B5;font-size:15px;" onmouseover="this.style.color='#C0392B'" onmouseout="this.style.color='#D4C5B5'">🗑</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div style="margin-top:16px;padding-top:16px;border-top:1px solid #E5DDD0;display:flex;justify-content:space-between;">
            <span style="font-size:14px;color:#6B6560;">Total</span>
            <span style="font-size:18px;font-weight:700;color:#1C1C1C;">{{ number_format($expenses->sum('amount'), 2) }} €</span>
        </div>
        @endif
    </div>
</div>
@endsection