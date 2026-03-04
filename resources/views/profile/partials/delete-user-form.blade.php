<section>
    <h2 style="font-size:15px;font-weight:600;color:#C0392B;margin-bottom:8px;">Supprimer mon compte</h2>
    <p style="font-size:13px;color:#6B6560;margin-bottom:14px;">Cette action est irréversible.</p>
    <button onclick="document.getElementById('delete-account-modal').style.display='flex'" class="btn-danger">Supprimer mon compte</button>
    <div id="delete-account-modal" style="display:none;position:fixed;inset:0;background:rgba(28,28,28,0.5);z-index:100;align-items:center;justify-content:center;padding:20px;">
        <div style="background:white;border-radius:16px;padding:28px;width:100%;max-width:400px;">
            <h3 style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:#1C1C1C;margin-bottom:8px;">Confirmer la suppression</h3>
            <p style="font-size:13px;color:#6B6560;margin-bottom:18px;">Entrez votre mot de passe pour confirmer.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" style="display:flex;flex-direction:column;gap:12px;">
                @csrf @method('DELETE')
                <input name="password" type="password" class="input" placeholder="Mot de passe" required>
                @error('password', 'userDeletion') <p style="font-size:12px;color:#C0392B;margin-top:-8px;">{{ $message }}</p> @enderror
                <div style="display:flex;gap:10px;">
                    <button type="button" onclick="document.getElementById('delete-account-modal').style.display='none'"
                            style="flex:1;border:1px solid #E5DDD0;background:transparent;border-radius:8px;padding:10px;font-family:'DM Sans',sans-serif;font-size:13px;cursor:pointer;">Annuler</button>
                    <button type="submit" style="flex:1;background:#C0392B;color:white;border:none;border-radius:8px;padding:10px;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
</section>