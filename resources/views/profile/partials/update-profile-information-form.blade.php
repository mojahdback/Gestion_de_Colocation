<section>
    <h2 style="font-size:15px;font-weight:600;color:#1C1C1C;margin-bottom:16px;">Informations personnelles</h2>
    <form method="POST" action="{{ route('profile.update') }}" style="display:flex;flex-direction:column;gap:14px;">
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
            @if(session('status') === 'profile-updated') <span style="font-size:13px;color:#1E7E3E;">✓ Sauvegardé !</span> @endif
        </div>
    </form>
</section>