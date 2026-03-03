@extends('layouts.app')
@section('title', 'Invitation')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
        <div class="text-5xl mb-4">📬</div>
        <h1 class="text-2xl font-bold text-gray-900">Invitation à rejoindre</h1>
        <p class="text-xl font-semibold text-indigo-600 mt-1">{{ $invitation->colocation->name }}</p>

        @if(!$invitation->isPending())
            <div class="mt-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                Cette invitation n'est plus valide
                ({{ $invitation->status === 'accepted' ? 'déjà acceptée' : ($invitation->status === 'refused' ? 'refusée' : 'expirée') }}).
            </div>
            <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-indigo-600 text-sm hover:underline">
                Retour au dashboard
            </a>
        @elseif(auth()->user()->email !== $invitation->email)
            <div class="mt-6 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl text-sm">
                ⚠️ Cette invitation est destinée à <strong>{{ $invitation->email }}</strong>.
                Vous êtes connecté(e) avec <strong>{{ auth()->user()->email }}</strong>.
            </div>
        @elseif(auth()->user()->hasActiveColocation())
            <div class="mt-6 bg-orange-50 border border-orange-200 text-orange-800 px-4 py-3 rounded-xl text-sm">
                ⚠️ Vous faites déjà partie d'une colocation active. Vous devez la quitter avant d'en rejoindre une nouvelle.
            </div>
        @else
            <p class="text-gray-500 mt-3 text-sm">
                Invitation pour <strong>{{ $invitation->email }}</strong>.
                @if($invitation->expires_at)
                    Expire {{ $invitation->expires_at->diffForHumans() }}.
                @endif
            </p>

            <div class="flex gap-3 mt-8">
                <form method="POST" action="{{ route('invitations.refuse', $invitation->token) }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full border border-gray-200 text-gray-600 py-3 rounded-xl text-sm font-medium hover:bg-gray-50 transition">
                        Refuser
                    </button>
                </form>
                <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}" class="flex-1">
                    @csrf
                    <button type="submit"
                            class="w-full bg-indigo-600 text-white py-3 rounded-xl text-sm font-medium hover:bg-indigo-700 transition shadow-sm">
                        Accepter 🎉
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
