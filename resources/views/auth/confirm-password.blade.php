<x-guest-layout>
<div>
    <h1 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:#1C1C1C;margin-bottom:8px;">Zone sécurisée 🔒</h1>
    <p style="font-size:14px;color:#6B6560;margin-bottom:24px;">Confirmez votre mot de passe pour continuer.</p>
    <form method="POST" action="{{ route('password.confirm') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" class="input" placeholder="••••••••" required>
            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="btn-primary">Confirmer</button>
    </form>
</div>
</x-guest-layout>