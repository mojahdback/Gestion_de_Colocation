<x-guest-layout>
<div>
    <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:6px;">Bon retour 👋</h1>
    <p style="font-size:14px;color:#6B6560;margin-bottom:28px;">Connectez-vous à votre espace colocation.</p>
    @if(session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:18px;">
        @csrf
        <div>
            <label for="email">Adresse email</label>
            <input id="email" name="email" type="email" class="input" placeholder="vous@exemple.com" value="{{ old('email') }}" required autofocus>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                <label for="password" style="margin-bottom:0;">Mot de passe</label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link">Oublié ?</a>
                @endif
            </div>
            <input id="password" name="password" type="password" class="input" placeholder="••••••••" required autocomplete="current-password">
            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;accent-color:#C4663A;">
            <label for="remember" style="margin-bottom:0;font-size:13px;color:#6B6560;cursor:pointer;">Se souvenir de moi</label>
        </div>
        <button type="submit" class="btn-primary">Se connecter</button>
        <p style="text-align:center;font-size:13px;color:#6B6560;">Pas encore de compte ? <a href="{{ route('register') }}" class="link">S'inscrire</a></p>
    </form>
</div>
</x-guest-layout>