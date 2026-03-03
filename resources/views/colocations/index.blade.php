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
   @forelse($colocations as $colocation)
    ...
   @empty
    <a href="{{ route('colocations.create') }}"
       class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-medium hover:bg-indigo-700 transition shadow-sm">
        + Créer une colocation
    </a>
    @endforelse
    </div>

     @forelse($colocations as $colocation)

    {{-- Active colocation card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        ...
    </div>

    @empty

    {{-- No colocation state --}}
    <div class="bg-white rounded-2xl border border-dashed border-gray-300 p-12 text-center">
        <div class="text-5xl mb-4">🏡</div>
        <h3 class="text-lg font-semibold text-gray-900">
            Vous n'avez pas de colocation active
        </h3>
        <p class="text-gray-500 mt-2 text-sm">
            Créez une nouvelle colocation ou attendez une invitation.
        </p>
        <a href="{{ route('colocations.create') }}"
           class="inline-block mt-6 bg-indigo-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-indigo-700 transition">
            Créer une colocation
        </a>
    </div>

@endforelse

</div>
@endsection
