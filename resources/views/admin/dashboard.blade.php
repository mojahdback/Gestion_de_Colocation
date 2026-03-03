@extends('layouts.app')
@section('title', 'Administration')

@section('content')
<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-gray-900">⚙️ Dashboard Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Vue globale de la plateforme</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        @foreach([
            ['label' => 'Utilisateurs', 'value' => $stats['users'], 'color' => 'blue'],
            ['label' => 'Colocations', 'value' => $stats['colocations'], 'color' => 'indigo'],
            ['label' => 'Actives', 'value' => $stats['active'], 'color' => 'green'],
            ['label' => 'Dépenses (€)', 'value' => number_format($stats['expenses'], 2), 'color' => 'amber'],
            ['label' => 'Bannis', 'value' => $stats['banned'], 'color' => 'red'],
        ] as $stat)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
                <p class="text-xs font-medium text-gray-500">{{ $stat['label'] }}</p>
                <p class="text-xl font-bold text-gray-900 mt-1">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Users table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">👤 Utilisateurs</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 border-b border-gray-100">
                            <th class="pb-2 text-left font-medium">Nom</th>
                            <th class="pb-2 text-left font-medium">Email</th>
                            <th class="pb-2 text-center font-medium">Rép.</th>
                            <th class="pb-2 text-right font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($users as $user)
                            <tr class="{{ $user->is_banned ? 'bg-red-50' : '' }}">
                                <td class="py-2.5 font-medium text-gray-800">
                                    {{ $user->name }}
                                    @if($user->is_admin) <span class="text-orange-500 text-xs">admin</span> @endif
                                    @if($user->is_banned) <span class="text-red-500 text-xs">banni</span> @endif
                                </td>
                                <td class="py-2.5 text-gray-500 text-xs">{{ $user->email }}</td>
                                <td class="py-2.5 text-center">
                                    <span class="{{ $user->reputation >= 0 ? 'text-green-600' : 'text-red-600' }} font-semibold text-xs">
                                        {{ $user->reputation >= 0 ? '+' : '' }}{{ $user->reputation }}
                                    </span>
                                </td>
                                <td class="py-2.5 text-right">
                                    @if($user->id !== auth()->id())
                                        @if($user->is_banned)
                                            <form method="POST" action="{{ route('admin.users.unban', $user) }}" class="inline">
                                                @csrf
                                                <button class="text-xs text-green-600 hover:text-green-800 font-medium">Débannir</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.ban', $user) }}" class="inline"
                                                  onsubmit="return confirm('Bannir {{ $user->name }} ?')">
                                                @csrf
                                                <button class="text-xs text-red-500 hover:text-red-700 font-medium">Bannir</button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-300">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

        {{-- Recent colocations --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-900 mb-4">🏠 Colocations récentes</h2>
            <div class="space-y-3">
                @foreach($colocations as $col)
                    <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $col->name }}</p>
                            <p class="text-xs text-gray-500">Owner: {{ $col->owner->name }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $col->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $col->status }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
