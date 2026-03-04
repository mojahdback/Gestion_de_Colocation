<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ColocApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --terracotta:#C4663A; --terracotta-dark:#A3522A; --cream:#FDFAF4; --ink:#1C1C1C; --muted:#6B6560; --border:#E5DDD0; }
        *{box-sizing:border-box;margin:0;padding:0;}
        body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;background:var(--cream);}
        .left-panel{width:420px;flex-shrink:0;background:var(--terracotta);position:relative;display:flex;flex-direction:column;justify-content:flex-end;padding:48px;overflow:hidden;}
        .left-panel::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(255,255,255,0.03) 40px,rgba(255,255,255,0.03) 80px);}
        .deco-top{position:absolute;top:-80px;right:-80px;width:300px;height:300px;border-radius:50%;border:60px solid rgba(255,255,255,0.06);}
        .deco-bottom{position:absolute;bottom:-60px;left:-60px;width:250px;height:250px;border-radius:50%;border:50px solid rgba(255,255,255,0.06);}
        .right-panel{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px;overflow-y:auto;}
        .auth-card{width:100%;max-width:400px;}
        .input{width:100%;border:1.5px solid var(--border);border-radius:8px;padding:11px 14px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--ink);background:white;transition:border-color 0.2s,box-shadow 0.2s;outline:none;}
        .input:focus{border-color:var(--terracotta);box-shadow:0 0 0 3px rgba(196,102,58,0.12);}
        .input::placeholder{color:#C0B8B0;}
        label{font-size:13px;font-weight:500;color:var(--muted);display:block;margin-bottom:6px;}
        .btn-primary{width:100%;background:var(--terracotta);color:white;border:none;border-radius:8px;padding:12px;font-family:'DM Sans',sans-serif;font-size:15px;font-weight:600;cursor:pointer;transition:all 0.2s;}
        .btn-primary:hover{background:var(--terracotta-dark);transform:translateY(-1px);box-shadow:0 4px 14px rgba(196,102,58,0.35);}
        .link{color:var(--terracotta);text-decoration:none;font-weight:500;font-size:13px;}
        .link:hover{text-decoration:underline;}
        .error-msg{font-size:12px;color:#C0392B;margin-top:4px;}
        .status-msg{font-size:13px;color:#1E7E3E;background:#EDFAF1;border:1px solid #B8E8C6;padding:10px 14px;border-radius:8px;margin-bottom:16px;}
        @media(max-width:768px){.left-panel{display:none;}}
    </style>
</head>
<body>
    <div class="left-panel">
        <div class="deco-top"></div>
        <div class="deco-bottom"></div>
        <div style="position:relative;z-index:1;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:32px;">
                <div style="width:38px;height:38px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;">🏠</div>
                <span style="font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:white;">ColocApp</span>
            </div>
            <h2 style="font-family:'Playfair Display',serif;font-size:32px;font-weight:400;color:white;line-height:1.3;margin-bottom:16px;">
                Gérez votre<br><em>colocation</em><br>simplement
            </h2>
            <p style="font-size:15px;color:rgba(255,255,255,0.75);line-height:1.6;">Dépenses partagées, invitations, équilibres — tout en un seul endroit.</p>
            <div style="margin-top:36px;display:flex;flex-direction:column;gap:10px;">
                @php $features = ['💰 Suivi des dépenses', '⚖️ Balances automatiques', '📧 Invitations par email', '👥 Gestion des membres']; @endphp
                @foreach($features as $f)
                <div style="display:flex;align-items:center;gap:10px;color:rgba(255,255,255,0.85);font-size:14px;">
                    <span style="width:6px;height:6px;background:rgba(255,255,255,0.5);border-radius:50%;flex-shrink:0;"></span>{{ $f }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="right-panel">
        <div class="auth-card">{{ $slot }}</div>
    </div>
</body>
</html>