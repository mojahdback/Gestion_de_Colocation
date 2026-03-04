<x-guest-layout>
<div style="text-align:center;">
    <div style="font-size:56px;margin-bottom:20px;">📬</div>
    <h1 style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:#1C1C1C;margin-bottom:10px;">Vérifiez votre email</h1>
    <p style="font-size:14px;color:#6B6560;margin-bottom:24px;line-height:1.6;">Nous avons envoyé un lien de vérification à votre adresse email. Cliquez dessus pour activer votre compte.</p>
    @if(session('status') == 'verification-link-sent')
        <div class="status-msg" style="margin-bottom:20px;">Un nouveau lien a été envoyé !</div>
    @endif
    <div style="display:flex;flex-direction:column;gap:10px;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-primary">Renvoyer l'email</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;font-family:'DM Sans',sans-serif;font-size:13px;color:#6B6560;cursor:pointer;text-decoration:underline;">Se déconnecter</button>
        </form>
    </div>
</div>
</x-guest-layout>