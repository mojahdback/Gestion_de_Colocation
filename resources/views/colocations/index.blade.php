@extends('layouts.app')
@section('title', 'Ma Colocation')

@section('content')
<div class="space-y-6">

{{-- Header --}}
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Ma Colocation</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez vos dépenses partagées</p>
    </div>
    @if(!$colocation)
        <a href="{{ route('colocations.create') }}"
           class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition shadow-sm">
            + Créer une colocation
        </a>
    @endif
</div>

@if($colocation)
    {{-- Active colocation card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $colocation->name }}</h2>
            </div>
            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Active</span>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('colocations.show', $colocation) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                Voir le détail →
            </a>

            @if(auth()->id() === $colocation->role)
                <a href="{{ route('colocations.edit', $colocation) }}"
                   class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                    Modifier
                </a>
            @else
                <form method="POST" action="{{ route('colocations.leave', $colocation) }}"
                      onsubmit="return confirm('Voulez-vous vraiment quitter cette colocation ?')">
                    @csrf
                    <button class="bg-orange-100 text-orange-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-orange-200 transition">
                        Quitter
                    </button>
                </form>
            @endif

            @if(auth()->id() === $colocation->role)
                <form method="POST" action="{{ route('colocations.cancel', $colocation) }}"
                      onsubmit="return confirm('Annuler définitivement la colocation ? Cette action est irréversible.')">
                    @csrf
                    <button class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-200 transition">
                        Annuler la colocation
                    </button>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
