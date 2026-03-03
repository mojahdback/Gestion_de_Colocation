@extends('layouts.app')
@section('title', $colocation->name)

@section('content')
<div class="space-y-6">

{{-- Header --}}
<div class="flex flex-wrap items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-gray-900">{{ $colocation->name }}</h1>
            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Active</span>
        </div>
        @if($colocation->address)
            <p class="text-sm text-gray-500 mt-0.5">📍 {{ $colocation->address }}</p>
        @endif
    </div>
    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-indigo-600">← Retour</a>
</div>

{{-- Tabs-like layout: 2 columns on desktop --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: Members + Balances + Settlements --}}
    <div class="space-y-5">

        {{-- Members --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-900">👥 Membres</h2>
                @if(auth()->id() === $colocation->role)
                    <button onclick="document.getElementById('invite-modal').classList.remove('hidden')"
                            class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition font-medium">
                        + Inviter
                    </button>
                @endif
            </div>

            <div class="space-y-3">
                @foreach($members as $member)
                    @php $balance = $balances[$member->id] ?? 0; @endphp
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold text-sm">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $member->name }}
                                    @if($member->id === $colocation-> role)
                                        <span class="text-xs text-indigo-500">(owner)</span>
                                    @endif
                                    @if($member->id === auth()->id())
                                        <span class="text-xs text-gray-400">(moi)</span>
                                    @endif
                                </p>
                                <p class="text-xs {{ $member->reputation >= 0 ? 'text-green-600' : 'text-red-500' }}">
                                    Réputation: {{ $member->reputation >= 0 ? '+' : '' }}{{ $member->reputation }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $balance >= 0 ? '+' : '' }}{{ number_format($balance, 2) }} €
                            </p>
                            @if(auth()->id() === $colocation->role && $member->id !== $colocation->owner)
                                <form method="POST" action="{{ route('colocations.members.remove', [$colocation, $member]) }}"
                                      onsubmit="return confirm('Retirer {{ $member->name }} ?')">
                                    @csrf @method('DELETE')
                                    <button class="text-xs text-red-400 hover:text-red-600 mt-0.5">Retirer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Settlements --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">💸 Qui doit à qui</h2>

            @if(empty($settlements))
                <p class="text-sm text-gray-400 text-center py-4">Tout le monde est quitte ! 🎉</p>
            @else
                <div class="space-y-3">
                    @foreach($settlements as $s)
                        <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                            <div class="text-sm">
                                <span class="font-medium text-gray-800">{{ $s['from']->name }}</span>
                                <span class="text-gray-400 mx-1">→</span>
                                <span class="font-medium text-gray-800">{{ $s['to']->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-red-600">{{ number_format($s['amount'], 2) }} €</span>
                                @if($s['from']->id === auth()->id())
                                    <form method="POST" action="{{ route('payments.store', $colocation) }}">
                                        @csrf
                                        <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                                        <input type="hidden" name="amount" value="{{ $s['amount'] }}">
                                        <button type="submit"
                                                class="text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-lg hover:bg-green-200 transition font-medium">
                                            Marquer payé ✓
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Categories (owner only) --}}
        @if(auth()->id() === $colocation->role)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <h2 class="font-semibold text-gray-900 mb-3">🏷️ Catégories</h2>
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($categories as $cat)
                        <div class="flex items-center gap-1.5 bg-gray-50 rounded-full px-3 py-1">
                            <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $cat->color }}"></span>
                            <span class="text-xs text-gray-700">{{ $cat->name }}</span>
                            <form method="POST" action="{{ route('categories.destroy', [$colocation, $cat]) }}">
                                @csrf @method('DELETE')
                                <button class="text-gray-300 hover:text-red-500 text-xs ml-0.5">✕</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <form method="POST" action="{{ route('categories.store', $colocation) }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="Nouvelle catégorie" required
                           class="flex-1 text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <input type="color" name="color" value="#6366f1"
                           class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer p-1">
                    <button type="submit"
                            class="bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">+</button>
                </form>
            </div>
        @endif
    </div>

    {{-- RIGHT: Expenses --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Add Expense --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">➕ Ajouter une dépense</h2>
            <form method="POST" action="{{ route('expenses.store', $colocation) }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-medium text-gray-600">Titre *</label>
                        <input type="text" name="title" required placeholder="Ex: Courses Aldi"
                               class="mt-1 w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Montant (€) *</label>
                        <input type="number" name="amount" step="0.01" min="0.01" required placeholder="0.00"
                               class="mt-1 w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Date *</label>
                        <input type="date" name="expense_date" required value="{{ date('Y-m-d') }}"
                               class="mt-1 w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Payé par *</label>
                        <select name="paid_by" required
                                class="mt-1 w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            @foreach($members as $m)
                                <option value="{{ $m->id }}" {{ $m->id === auth()->id() ? 'selected' : '' }}>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Catégorie</label>
                        <select name="category_id"
                                class="mt-1 w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                            <option value="">— Sans catégorie —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600">Notes</label>
                        <input type="text" name="notes" placeholder="Optionnel"
                               class="mt-1 w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    </div>
                </div>
                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition text-sm">
                    Ajouter la dépense
                </button>
            </form>
        </div>

        {{-- Expense list --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <h2 class="font-semibold text-gray-900">📋 Dépenses</h2>

                {{-- Month filter --}}
                <form method="GET" action="{{ route('colocations.show', $colocation) }}" class="flex items-center gap-2">
                    <select name="month" onchange="this.form.submit()"
                            class="text-sm border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-indigo-300">
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
                <p class="text-center text-gray-400 text-sm py-8">Aucune dépense pour cette période.</p>
            @else
                <div class="space-y-2">
                    @foreach($expenses as $expense)
                        <div class="flex items-start justify-between bg-gray-50 rounded-xl px-4 py-3 hover:bg-gray-100 transition">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5">
                                    @if($expense->category)
                                        <span class="inline-block w-3 h-3 rounded-full" style="background-color: {{ $expense->category->color }}"></span>
                                    @else
                                        <span class="inline-block w-3 h-3 rounded-full bg-gray-300"></span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $expense->title }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $expense->paidBy->name }} •
                                        {{ $expense->expense_date->format('d/m/Y') }}
                                        @if($expense->category)
                                            • <span style="color: {{ $expense->category->color }}">{{ $expense->category->name }}</span>
                                        @endif
                                    </p>
                                    @if($expense->notes)
                                        <p class="text-xs text-gray-400 mt-0.5 italic">{{ $expense->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-gray-900">{{ number_format($expense->amount, 2) }} €</span>
                                @if($expense->paid_by === auth()->id() || auth()->id() === $colocation->owner_id)
                                    <form method="POST" action="{{ route('expenses.destroy', [$colocation, $expense]) }}"
                                          onsubmit="return confirm('Supprimer cette dépense ?')">
                                        @csrf @method('DELETE')
                                        <button class="text-gray-300 hover:text-red-500 transition text-sm">🗑</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Total for filtered period --}}
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between text-sm">
                    <span class="text-gray-500">Total {{ $month ? 'ce mois' : 'toutes périodes' }}</span>
                    <span class="font-bold text-gray-900">{{ number_format($expenses->sum('amount'), 2) }} €</span>
                </div>
            @endif
        </div>
    </div>
</div>

</div>

{{-- Invite Modal --}}
@if(auth()->id() === $colocation->role)
<div id="invite-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Inviter un membre</h3>
            <button onclick="document.getElementById('invite-modal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form method="POST" action="{{ route('invitations.store', $colocation) }}">
            @csrf
            <label class="text-sm font-medium text-gray-700">Adresse email</label>
            <input type="email" name="email" required placeholder="prenom@email.com"
                   class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <div class="flex gap-3 mt-4">
                <button type="button"
                        onclick="document.getElementById('invite-modal').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit"
                        class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-medium hover:bg-indigo-700 transition">
                    Envoyer l'invitation
                </button>
            </div>
        </form>

        {{-- Pending invitations list --}}
        @php $pendingInvitations = $colocation->invitations()->where('status', 'pending')->get(); @endphp
        @if($pendingInvitations->count())
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-500 mb-2">Invitations en attente</p>
                @foreach($pendingInvitations as $inv)
                    <div class="flex justify-between text-xs text-gray-600 py-1">
                        <span>{{ $inv->email }}</span>
                        <span class="text-gray-400">Expire {{ $inv->expires_at?->diffForHumans() }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endif

@endsection
