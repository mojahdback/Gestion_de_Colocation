<x-guest-layout>
<div>
    <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:6px;">Créer un compte</h1>
    <p style="font-size:14px;color:#6B6560;margin-bottom:28px;">Rejoignez ColocApp et gérez votre logement partagé.</p>
    <form method="POST" action="{{ route('register') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label for="name">Nom complet</label>
            <input id="name" name="name" type="text" class="input" placeholder="Jean Dupont" value="{{ old('name') }}" required autofocus>
            @error('name') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="email">Adresse email</label>
            <input id="email" name="email" type="email" class="input" placeholder="vous@exemple.com" value="{{ old('email') }}" required>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" class="input" placeholder="8 caractères minimum" required>
            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="input" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-primary" style="margin-top:4px;">Créer mon compte</button>
        <p style="text-align:center;font-size:13px;color:#6B6560;">Déjà inscrit ? <a href="{{ route('login') }}" class="link">Se connecter</a></p>
    </form>
</div>
</x-guest-layout>