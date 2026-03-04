@extends('layouts.app')
@section('title', 'Mon Profil')

@section('content')
<div style="max-width:640px;margin:0 auto;">
    <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:24px;">Mon Profil</h1>

    <!-- Profile info -->
    <div class="card-elevated" style="padding:28px;margin-bottom:16px;">
        <h2 style="font-size:16px;font-weight:600;color:#1C1C1C;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #F5F0E8;">Informations personnelles</h2>
        <form method="POST" action="{{ route('profile.update') }}" style="display:flex;flex-direction:column;gap:16px;">
            @csrf @method('PATCH')
            <div>
                <label for="name">Nom</label>
                <input id="name" name="name" type="text" class="input" value="{{ old('name', $user->name) }}" required>
                @error('name') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="email">Email</label>
                <input id="email" name="email" type="email" class="input" value="{{ old('email', $user->email) }}" required>
                @error('email') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <button type="submit" class="btn-primary">Sauvegarder</button>
                @if(session('status') === 'profile-updated')
                <span style="font-size:13px;color:#1E7E3E;">✓ Sauvegardé !</span>
                @endif
            </div>
        </form>
    </div>

    <!-- Password update -->
    <div class="card-elevated" style="padding:28px;margin-bottom:16px;">
        <h2 style="font-size:16px;font-weight:600;color:#1C1C1C;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid #F5F0E8;">Changer le mot de passe</h2>
        <form method="POST" action="{{ route('password.update') }}" style="display:flex;flex-direction:column;gap:16px;">
            @csrf @method('PUT')
            <div>
                <label>Mot de passe actuel</label>
                <input name="current_password" type="password" class="input" placeholder="••••••••">
                @error('current_password', 'updatePassword') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Nouveau mot de passe</label>
                <input name="password" type="password" class="input" placeholder="••••••••">
                @error('password', 'updatePassword') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div>
                <label>Confirmer</label>
                <input name="password_confirmation" type="password" class="input" placeholder="••••••••">
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <button type="submit" class="btn-primary">Mettre à jour</button>
                @if(session('status') === 'password-updated')
                <span style="font-size:13px;color:#1E7E3E;">✓ Modifié !</span>
                @endif
            </div>
        </form>
    </div>

    <!-- Delete account -->
    <div class="card" style="padding:24px;border-color:#F5C2BA;">
        <h2 style="font-size:16px;font-weight:600;color:#C0392B;margin-bottom:12px;">Supprimer mon compte</h2>
        <p style="font-size:14px;color:#6B6560;margin-bottom:16px;">Cette action est irréversible. Toutes vos données seront supprimées.</p>
        <button onclick="document.getElementById('delete-modal').style.display='flex'" class="btn-danger">Supprimer mon compte</button>
    </div>
</div>

<!-- Delete Modal -->
<div id="delete-modal" style="display:none;position:fixed;inset:0;background:rgba(28,28,28,0.5);z-index:100;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;border-radius:16px;padding:28px;width:100%;max-width:420px;">
        <h3 style="font-family:'Playfair Display',serif;font-size:20px;font-weight:700;color:#1C1C1C;margin-bottom:10px;">Confirmer la suppression</h3>
        <p style="font-size:14px;color:#6B6560;margin-bottom:20px;">Entrez votre mot de passe pour confirmer.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" style="display:flex;flex-direction:column;gap:14px;">
            @csrf @method('DELETE')
            <div>
                <label>Mot de passe</label>
                <input name="password" type="password" class="input" placeholder="••••••••" required>
                @error('password', 'userDeletion') <p style="font-size:12px;color:#C0392B;margin-top:4px;">{{ $message }}</p> @enderror
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" onclick="document.getElementById('delete-modal').style.display='none'"
                        style="flex:1;border:1px solid #E5DDD0;background:transparent;border-radius:8px;padding:11px;font-family:'DM Sans',sans-serif;font-size:14px;color:#6B6560;cursor:pointer;">
                    Annuler
                </button>
                <button type="submit" style="flex:1;background:#C0392B;color:white;border:none;border-radius:8px;padding:11px;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:600;cursor:pointer;">
                    Supprimer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection