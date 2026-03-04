<x-guest-layout>
<div>
    <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:6px;">Mot de passe oublié</h1>
    <p style="font-size:14px;color:#6B6560;margin-bottom:24px;">Entrez votre email et nous vous enverrons un lien de réinitialisation.</p>
    @if(session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('password.email') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label for="email">Adresse email</label>
            <input id="email" name="email" type="email" class="input" placeholder="vous@exemple.com" value="{{ old('email') }}" required autofocus>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn-primary">Envoyer le lien</button>
        <p style="text-align:center;font-size:13px;color:#6B6560;"><a href="{{ route('login') }}" class="link">← Retour à la connexion</a></p>
    </form>
</div>
</x-guest-layout>