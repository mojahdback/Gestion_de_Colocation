<x-guest-layout>
<div>
    <h1 style="font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:#1C1C1C;margin-bottom:24px;">Nouveau mot de passe</h1>
    <form method="POST" action="{{ route('password.store') }}" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="input" value="{{ old('email', $request->email) }}" required>
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password">Nouveau mot de passe</label>
            <input id="password" name="password" type="password" class="input" placeholder="8 caractères minimum" required>
            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password_confirmation">Confirmer</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="input" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-primary">Réinitialiser</button>
    </form>
</div>
</x-guest-layout>