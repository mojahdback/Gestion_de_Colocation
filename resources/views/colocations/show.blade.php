@extends('layouts.app')
@section('title', $colocation->name)

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

    <!-- Header -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <a href="{{ route('dashboard') }}" style="font-size:13px;color:#6B6560;text-decoration:none;display:inline-flex;align-items:center;gap:4px;margin-bottom:10px;">← Tableau de bord</a>
            <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;">{{ $colocation->name }}</h1>
                <span class="badge {{ $colocation->status === 'active' ? 'badge-green' : 'badge-gray' }}">{{ $colocation->status }}</span>
            </div>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            @if(auth()->id() === optional($colocation->owner())->id)
            <button onclick="document.getElementById('invite-modal').style.display='flex'" class="btn-primary">+ Inviter un membre</button>
            @endif
            @if(auth()->id() !== optional($colocation->owner())->id)
            <form method="POST" action="{{ route('colocations.leave', $colocation) }}" onsubmit="return confirm('Quitter cette colocation ?')">
                @csrf
                <button type="submit" class="btn-danger">Quitter</button>
            </form>
            @endif
        </div>
    </div>

    <!-- Main Grid -->
    <div style="display:grid;grid-template-columns:320px 1fr;gap:20px;align-items:start;">

        <!-- LEFT COLUMN -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Members -->
            <div class="card-elevated" style="padding:20px;">
                <h2 style="font-size:15px;font-weight:600;color:#1C1C1C;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <span>👥</span> Membres ({{ $members->count() }})
                </h2>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @foreach($members as $member)
                    @php $balance = $balances[$member->id] ?? 0; @endphp
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#F5C2A0,#C4663A);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0;">
                                {{ substr($member->name,0,1) }}
                            </div>
                            <div>
                                <div style="font-size:14px;font-weight:500;color:#1C1C1C;display:flex;align-items:center;gap:5px;">
                                    {{ $member->name }}
                                    @if($member->id === optional($colocation->owner())->id)
                                        <span style="font-size:10px;background:#FDF0EA;color:#C4663A;padding:1px 6px;border-radius:10px;">owner</span>
                                    @endif
                                    @if($member->id === auth()->id())
                                        <span style="font-size:10px;color:#B0A89E;">(moi)</span>
                                    @endif
                                </div>
                                <div style="font-size:12px;color:{{ $member->reputation >= 0 ? '#1E7E3E' : '#C0392B' }};">
                                    rép. {{ $member->reputation >= 0 ? '+' : '' }}{{ $member->reputation }}
                                </div>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:14px;font-weight:700;color:{{ $balance >= 0 ? '#1E7E3E' : '#C0392B' }};">
                                {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2) }} €
                            </div>
                            @if(auth()->id() === optional($colocation->owner())->id && $member->id !== optional($colocation->owner())->id)
                            <form method="POST" action="{{ route('colocations.removeMember', [$colocation, $member]) }}" onsubmit="return confirm('Retirer {{ $member->name }} ?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;font-size:11px;color:#C0392B;cursor:pointer;padding:0;">Retirer</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Settlements -->
            <div class="card-elevated" style="padding:20px;">
                <h2 style="font-size:15px;font-weight:600;color:#1C1C1C;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
                    <span>💸</span> Règlements
                </h2>
                @if(empty($settlements))
                    <div style="text-align:center;padding:20px 0;">
                        <div style="font-size:32px;margin-bottom:8px;">🎉</div>
                        <p style="font-size:13px;color:#6B6560;">Tout le monde est quitte !</p>
                    </div>
                @else
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        @foreach($settlements as $s)
                        <div style="background:#F5F0E8;border-radius:10px;padding:12px 14px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                                <div style="font-size:13px;color:#1C1C1C;">
                                    <strong>{{ $s['from'] }}</strong>
                                    <span style="color:#B0A89E;margin:0 4px;">→</span>
                                    <strong>{{ $s['to'] }}</strong>
                                </div>
                                <span style="font-size:14px;font-weight:700;color:#C0392B;">{{ number_format($s['amount'], 2) }} €</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Categories -->
            <div class="card-elevated" style="padding:20px;">
                <h2 style="font-size:15px;font-weight:600;color:#1C1C1C;margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                    <span>🏷️</span> Catégories
                </h2>
                <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px;">
                    @forelse($categories as $cat)
                    <div style="display:flex;align-items:center;gap:6px;background:#F5F0E8;border-radius:20px;padding:4px 12px;">
                        <span style="font-size:13px;color:#1C1C1C;">{{ $cat->name }}</span>
                        @if(auth()->id() === optional($colocation->owner())->id)
                        <form method="POST" action="{{ route('categories.destroy', $cat) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none;border:none;cursor:pointer;color:#B0A89E;font-size:12px;line-height:1;padding:0;margin-left:2px;" onmouseover="this.style.color='#C0392B'" onmouseout="this.style.color='#B0A89E'">×</button>
                        </form>
                        @endif
                    </div>
                    @empty
                    <p style="font-size:13px;color:#B0A89E;">Aucune catégorie</p>
                    @endforelse
                </div>
                @if(auth()->id() === optional($colocation->owner())->id)
                <form method="POST" action="{{ route('categories.store', $colocation) }}" style="display:flex;gap:8px;">
                    @csrf
                    <input type="text" name="name" class="input" placeholder="Nouvelle catégorie" required style="flex:1;">
                    <button type="submit" class="btn-primary" style="padding:10px 14px;flex-shrink:0;">+</button>
                </form>
                @endif
            </div>

            <!-- Danger Zone (owner) -->
            @if(auth()->id() === optional($colocation->owner())->id)
            <div class="card" style="padding:18px;border-color:#F5C2BA;">
                <h3 style="font-size:13px;font-weight:600;color:#C0392B;margin-bottom:12px;">Zone dangereuse</h3>
                <form method="POST" action="{{ route('colocations.destroy', $colocation) }}" onsubmit="return confirm('Annuler définitivement la colocation ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" style="width:100%;justify-content:center;">Annuler la colocation</button>
                </form>
            </div>
            @endif
        </div>

        <!-- RIGHT COLUMN — Expenses -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Add Expense Form -->
            <div class="card-elevated" style="padding:24px;">
                <h2 style="font-size:15px;font-weight:600;color:#1C1C1C;margin-bottom:18px;display:flex;align-items:center;gap:8px;">
                    <span>➕</span> Ajouter une dépense
                </h2>
                <form method="POST" action="{{ route('expenses.store', $colocation) }}">
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div>
                            <label>Titre *</label>
                            <input type="text" name="title" class="input" placeholder="Ex: Courses Aldi" required>
                        </div>
                        <div>
                            <label>Montant (€) *</label>
                            <input type="number" name="amount" class="input" step="0.01" min="0.01" placeholder="0.00" required>
                        </div>
                        <div>
                            <label>Date *</label>
                            <input type="date" name="date" class="input" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div>
                            <label>Payé par *</label>
                            <select name="payer_id" class="input" required>
                                @foreach($members as $m)
                                <option value="{{ $m->id }}" {{ $m->id === auth()->id() ? 'selected' : '' }}>{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="grid-column:span 2;">
                            <label>Catégorie</label>
                            <select name="category_id" class="input" required>
                                <option value="">— Sans catégorie —</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary" style="margin-top:16px;width:100%;justify-content:center;">
                        Ajouter la dépense
                    </button>
                </form>
            </div>

            <!-- Expense List -->
            <div class="card-elevated" style="padding:24px;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;flex-wrap:wrap;gap:12px;">
                    <h2 style="font-size:15px;font-weight:600;color:#1C1C1C;display:flex;align-items:center;gap:8px;">
                        <span>📋</span> Dépenses
                    </h2>
                    <!-- Month filter -->
                    <form method="GET" action="{{ route('colocations.show', $colocation) }}">
                        <select name="month" onchange="this.form.submit()" style="border:1px solid #E5DDD0;border-radius:8px;padding:6px 12px;font-size:13px;color:#1C1C1C;background:white;cursor:pointer;outline:none;">
                            <option value="">Tous les mois</option>
                            @foreach($months as $m)
                            <option value="{{ $m }}" {{ $month === $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $m)->translatedFormat('F Y') }}
                            </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if($expenses->isEmpty())
                <div style="text-align:center;padding:40px 0;">
                    <div style="font-size:40px;margin-bottom:12px;">💰</div>
                    <p style="font-size:14px;color:#B0A89E;">Aucune dépense pour cette période.</p>
                </div>
                @else
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach($expenses as $expense)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px;background:#F5F0E8;border-radius:10px;transition:background 0.2s;"
                         onmouseover="this.style.background='#EDE5DA'" onmouseout="this.style.background='#F5F0E8'">
                        <div style="display:flex;align-items:center;gap:12px;min-width:0;">
                            <div style="width:36px;height:36px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;border:1px solid #E5DDD0;">
                                {{ $expense->category ? '🏷️' : '💳' }}
                            </div>
                            <div style="min-width:0;">
                                <p style="font-size:14px;font-weight:500;color:#1C1C1C;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $expense->title }}</p>
                                <p style="font-size:12px;color:#6B6560;margin-top:1px;">
                                    {{ optional($expense->payer)->name }} •
                                    {{ \Carbon\Carbon::parse($expense->date)->format('d/m/Y') }}
                                    @if($expense->category) • {{ $expense->category->name }} @endif
                                </p>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;flex-shrink:0;">
                            <span style="font-size:15px;font-weight:700;color:#1C1C1C;">{{ number_format($expense->amount, 2) }} €</span>
                            @if($expense->payer_id === auth()->id() || auth()->id() === optional($colocation->owner())->id)
                            <form method="POST" action="{{ route('expenses.destroy', $expense) }}" onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;cursor:pointer;color:#D4C5B5;font-size:16px;transition:color 0.2s;"
                                        onmouseover="this.style.color='#C0392B'" onmouseout="this.style.color='#D4C5B5'">🗑</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Total -->
                <div style="margin-top:16px;padding-top:16px;border-top:1px solid #E5DDD0;display:flex;justify-content:space-between;align-items:center;">
                    <span style="font-size:14px;color:#6B6560;">Total {{ $month ? 'ce mois' : '(toutes périodes)' }}</span>
                    <span style="font-size:17px;font-weight:700;color:#1C1C1C;">{{ number_format($expenses->sum('amount'), 2) }} €</span>
                </div>
                @endif
            </div>

        </div>
    </div>

</div>

<!-- Invite Modal -->
<div id="invite-modal" style="display:none;position:fixed;inset:0;background:rgba(28,28,28,0.5);z-index:100;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;border-radius:16px;padding:28px;width:100%;max-width:440px;box-shadow:0 20px 60px rgba(28,28,28,0.2);">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <h3 style="font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:#1C1C1C;">Inviter un membre</h3>
            <button onclick="document.getElementById('invite-modal').style.display='none'" style="background:none;border:none;cursor:pointer;font-size:20px;color:#B0A89E;line-height:1;">×</button>
        </div>
        <form method="POST" action="{{ route('invitations.store', $colocation) }}" style="display:flex;flex-direction:column;gap:14px;">
            @csrf
            <div>
                <label>Adresse email *</label>
                <input type="email" name="email" class="input" placeholder="prenom@email.com" required>
            </div>
            <div style="display:flex;gap:10px;margin-top:4px;">
                <button type="button" onclick="document.getElementById('invite-modal').style.display='none'"
                        style="flex:1;border:1px solid #E5DDD0;background:transparent;border-radius:8px;padding:11px;font-family:'DM Sans',sans-serif;font-size:14px;color:#6B6560;cursor:pointer;">
                    Annuler
                </button>
                <button type="submit" class="btn-primary" style="flex:1;justify-content:center;">Envoyer</button>
            </div>
        </form>
    </div>
</div>
@endsection