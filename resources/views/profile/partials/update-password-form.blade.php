<section>
    <h2 style="font-size:15px;font-weight:600;color:#1C1C1C;margin-bottom:16px;">Changer le mot de passe</h2>
    <form method="POST" action="{{ route('password.update') }}" style="display:flex;flex-direction:column;gap:14px;">
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
            @if(session('status') === 'password-updated') <span style="font-size:13px;color:#1E7E3E;">✓ Modifié !</span> @endif
        </div>
    </form>
</section>