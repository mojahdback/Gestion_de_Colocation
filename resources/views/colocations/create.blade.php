@extends('layouts.app')
@section('title', 'Créer une colocation')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">🏡 Créer une colocation</h1>

        <form method="POST" action="{{ route('colocations.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="text-sm font-medium text-gray-700">Nom de la colocation *</label>
                <input type="text" id="name" name="name" required maxlength="255"
                       value="{{ old('name') }}"
                       placeholder="Ex: Appart 3 rue des Lilas"
                       class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="text-sm font-medium text-gray-700">Adresse</label>
                <input type="text" id="address" name="address" maxlength="500"
                       value="{{ old('address') }}"
                       placeholder="Ex: 3 rue des Lilas, 75011 Paris"
                       class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            </div>

            <div>
                <label for="description" class="text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="3" maxlength="1000"
                          placeholder="Quelques mots sur votre colocation..."
                          class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300 resize-none">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('dashboard') }}"
                   class="flex-1 text-center border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="flex-1 bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-medium hover:bg-indigo-700 transition shadow-sm">
                    Créer la colocation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
