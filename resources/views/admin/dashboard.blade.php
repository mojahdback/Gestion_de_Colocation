@extends('layouts.app')
@section('title', 'Administration')

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

    <!-- Header -->
    <div>
        <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:4px;">⚙️ Dashboard Admin</h1>
        <p style="font-size:14px;color:#6B6560;">Vue globale de la plateforme</p>
    </div>

    <!-- Stats -->
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px;">
        @php
        $statsConfig = [
            ['label'=>'Utilisateurs','value'=>$stats['users'],'icon'=>'👤','color'=>'#2563EB','bg'=>'#EEF4FF'],
            ['label'=>'Colocations','value'=>$stats['colocations'],'icon'=>'🏠','color'=>'#7C3AED','bg'=>'#F5F3FF'],
            ['label'=>'Actives','value'=>$stats['active'],'icon'=>'✅','color'=>'#1E7E3E','bg'=>'#EDFAF1'],
            ['label'=>'Dépenses (€)','value'=>number_format($stats['expenses'],2),'icon'=>'💰','color'=>'#B45309','bg'=>'#FFFBEB'],
            ['label'=>'Bannis','value'=>$stats['banned'],'icon'=>'🚫','color'=>'#C0392B','bg'=>'#FFF0EE'],
        ];
        @endphp
        @foreach($statsConfig as $s)
        <div class="card-elevated" style="padding:18px;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                <div style="width:34px;height:34px;background:{{ $s['bg'] }};border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:16px;">{{ $s['icon'] }}</div>
                <span style="font-size:12px;font-weight:500;color:#6B6560;">{{ $s['label'] }}</span>
            </div>
            <p style="font-size:22px;font-weight:700;color:#1C1C1C;">{{ $s['value'] }}</p>
        </div>
        @endforeach
    </div>

    <div style="display:grid;grid-template-columns:1fr 400px;gap:20px;align-items:start;">

        <!-- Users table -->
        <div class="card-elevated" style="padding:24px;">
            <h2 style="font-size:16px;font-weight:600;color:#1C1C1C;margin-bottom:18px;">👤 Utilisateurs</h2>
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:13px;">
                    <thead>
                        <tr style="border-bottom:2px solid #F5F0E8;">
                            <th style="text-align:left;padding:8px 12px;color:#6B6560;font-weight:500;">Nom</th>
                            <th style="text-align:left;padding:8px 12px;color:#6B6560;font-weight:500;">Email</th>
                            <th style="text-align:center;padding:8px 12px;color:#6B6560;font-weight:500;">Rép.</th>
                            <th style="text-align:center;padding:8px 12px;color:#6B6560;font-weight:500;">Statut</th>
                            <th style="text-align:right;padding:8px 12px;color:#6B6560;font-weight:500;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="border-bottom:1px solid #F5F0E8;{{ $user->is_banned ? 'background:#FFF8F7;' : '' }}">
                            <td style="padding:10px 12px;font-weight:500;color:#1C1C1C;">
                                {{ $user->name }}
                                @if($user->is_admin) <span style="font-size:10px;background:#FDF0EA;color:#C4663A;padding:1px 5px;border-radius:8px;margin-left:4px;">admin</span> @endif
                            </td>
                            <td style="padding:10px 12px;color:#6B6560;">{{ $user->email }}</td>
                            <td style="padding:10px 12px;text-align:center;">
                                <span style="font-weight:600;color:{{ $user->reputation >= 0 ? '#1E7E3E' : '#C0392B' }};">
                                    {{ $user->reputation >= 0 ? '+' : '' }}{{ $user->reputation }}
                                </span>
                            </td>
                            <td style="padding:10px 12px;text-align:center;">
                                <span class="badge {{ $user->is_banned ? 'badge-red' : 'badge-green' }}">
                                    {{ $user->is_banned ? 'Banni' : 'Actif' }}
                                </span>
                            </td>
                            <td style="padding:10px 12px;text-align:right;">
                                @if($user->id !== auth()->id())
                                    @if($user->is_banned)
                                    <form method="POST" action="{{ route('admin.users.unban', $user) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn-success" style="padding:4px 12px;font-size:12px;">Débannir</button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ route('admin.users.ban', $user) }}" style="display:inline;" onsubmit="return confirm('Bannir {{ $user->name }} ?')">
                                        @csrf
                                        <button type="submit" class="btn-danger" style="padding:4px 12px;font-size:12px;">Bannir</button>
                                    </form>
                                    @endif
                                @else
                                <span style="font-size:12px;color:#D4C5B5;">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:16px;">{{ $users->links() }}</div>
        </div>

        <!-- Recent colocations -->
        <div class="card-elevated" style="padding:24px;">
            <h2 style="font-size:16px;font-weight:600;color:#1C1C1C;margin-bottom:18px;">🏠 Colocations récentes</h2>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach($colocations as $col)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;background:#F5F0E8;border-radius:10px;">
                    <div>
                        <p style="font-size:14px;font-weight:500;color:#1C1C1C;">{{ $col->name }}</p>
                        <p style="font-size:12px;color:#6B6560;margin-top:2px;">{{ optional($col->owner())->name }}</p>
                    </div>
                    <span class="badge {{ $col->status === 'active' ? 'badge-green' : 'badge-gray' }}">{{ $col->status }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection