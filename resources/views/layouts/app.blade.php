<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ColocApp') — ColocApp</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --sand: #F5F0E8;
            --cream: #FDFAF4;
            --terracotta: #C4663A;
            --terracotta-light: #D4784C;
            --terracotta-dark: #A3522A;
            --sage: #7A9E7E;
            --ink: #1C1C1C;
            --muted: #6B6560;
            --border: #E5DDD0;
            --card: #FFFFFF;
            --gold: #C9A84C;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--cream);
            color: var(--ink);
            min-height: 100vh;
        }
        .font-display { font-family: 'Playfair Display', serif; }

        /* Navbar */
        .navbar {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            position: sticky; top: 0; z-index: 50;
        }

        /* Cards */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
        }
        .card-elevated {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(28,28,28,0.06);
        }

        /* Buttons */
        .btn-primary {
            background: var(--terracotta);
            color: white;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary:hover { background: var(--terracotta-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(196,102,58,0.3); }
        .btn-secondary {
            background: transparent;
            color: var(--ink);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-secondary:hover { background: var(--sand); border-color: #ccc; }
        .btn-danger {
            background: #FFF0EE;
            color: #C0392B;
            border: 1px solid #F5C2BA;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-danger:hover { background: #FDDAD6; }
        .btn-success {
            background: #EDFAF1;
            color: #1E7E3E;
            border: 1px solid #B8E8C6;
            border-radius: 8px;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-success:hover { background: #D5F3DF; }

        /* Form inputs */
        .input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }
        .input:focus { border-color: var(--terracotta); box-shadow: 0 0 0 3px rgba(196,102,58,0.12); }
        .input::placeholder { color: #B0A89E; }
        label { font-size: 13px; font-weight: 500; color: var(--muted); display: block; margin-bottom: 6px; }

        /* Flash messages */
        .flash { padding: 12px 16px; border-radius: 8px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .flash-success { background: #EDFAF1; color: #1E7E3E; border: 1px solid #B8E8C6; }
        .flash-error { background: #FFF0EE; color: #C0392B; border: 1px solid #F5C2BA; }
        .flash-info { background: #EEF4FF; color: #2563EB; border: 1px solid #BFDBFE; }

        /* Badge */
        .badge { display: inline-flex; align-items: center; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-green { background: #EDFAF1; color: #1E7E3E; }
        .badge-red { background: #FFF0EE; color: #C0392B; }
        .badge-amber { background: #FFFBEB; color: #92400E; }
        .badge-gray { background: var(--sand); color: var(--muted); }
        .badge-terracotta { background: #FDF0EA; color: var(--terracotta-dark); }

        /* Avatar */
        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #F5C2A0, #C4663A);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 14px; color: white;
            flex-shrink: 0;
        }

        /* Divider */
        .divider { height: 1px; background: var(--border); }

        /* Page transition */
        .page-content { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

        /* Texture overlay */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4'%3E%3Ccircle cx='1' cy='1' r='0.5' fill='%23C4663A' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }
        .relative { position: relative; z-index: 1; }
        main, .navbar, footer { position: relative; z-index: 1; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--sand); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar shadow-sm">
    <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
        <div style="display:flex;align-items:center;justify-content:space-between;height:60px;">

            <!-- Logo -->
            <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                <div style="width:32px;height:32px;background:var(--terracotta);border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;font-size:16px;">🏠</div>
                <span class="font-display" style="font-size:20px;font-weight:700;color:var(--ink);">ColocApp</span>
            </a>

            @auth
            <!-- Nav links -->
            <div style="display:flex;align-items:center;gap:28px;">
                <a href="{{ route('dashboard') }}" style="font-size:14px;font-weight:500;color:var(--muted);text-decoration:none;transition:color 0.2s;"
                   onmouseover="this.style.color='var(--terracotta)'" onmouseout="this.style.color='var(--muted)'">
                    Mes colocations
                </a>
                @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" style="font-size:14px;font-weight:500;color:var(--gold);text-decoration:none;display:flex;align-items:center;gap:5px;">
                    ⚙️ Admin
                </a>
                @endif
            </div>

            <!-- User menu -->
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                <div style="display:flex;flex-direction:column;">
                    <span style="font-size:13px;font-weight:600;color:var(--ink);">{{ auth()->user()->name }}</span>
                    <span class="badge {{ auth()->user()->reputation >= 0 ? 'badge-green' : 'badge-red' }}" style="font-size:11px;padding:1px 7px;">
                        {{ auth()->user()->reputation >= 0 ? '+' : '' }}{{ auth()->user()->reputation }} rép.
                    </span>
                </div>
                <a href="{{ route('profile.edit') }}" style="font-size:13px;color:var(--muted);text-decoration:none;margin-left:4px;">Profil</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="background:none;border:none;cursor:pointer;font-size:13px;color:var(--muted);font-family:inherit;transition:color 0.2s;"
                            onmouseover="this.style.color='#C0392B'" onmouseout="this.style.color='var(--muted)'">
                        Déconnexion
                    </button>
                </form>
            </div>
            @else
            <div style="display:flex;gap:12px;">
                <a href="{{ route('login') }}" class="btn-secondary" style="text-decoration:none;padding:8px 18px;">Connexion</a>
                <a href="{{ route('register') }}" class="btn-primary" style="text-decoration:none;padding:8px 18px;">S'inscrire</a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<div style="max-width:1200px;margin:0 auto;padding:16px 24px 0;">
    @foreach(['success', 'error', 'info'] as $type)
        @if(session($type))
        <div class="flash flash-{{ $type }}" id="flash-{{ $type }}" style="margin-bottom:12px;">
            <span style="font-size:16px;">{{ $type === 'success' ? '✓' : ($type === 'error' ? '✕' : 'ℹ') }}</span>
            <span>{{ session($type) }}</span>
            <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;cursor:pointer;opacity:0.5;font-size:16px;">×</button>
        </div>
        @endif
    @endforeach

    @if($errors->any())
    <div class="flash flash-error" style="margin-bottom:12px;flex-direction:column;align-items:flex-start;gap:4px;">
        @foreach($errors->all() as $error)
        <div style="display:flex;align-items:center;gap:8px;"><span>•</span> {{ $error }}</div>
        @endforeach
    </div>
    @endif
</div>

<!-- Main Content -->
<main style="max-width:1200px;margin:0 auto;padding:28px 24px 60px;">
    <div class="page-content">
        @yield('content')
    </div>
</main>

<!-- Footer -->
<footer style="border-top:1px solid var(--border);padding:20px 24px;position:relative;z-index:1;">
    <p style="text-align:center;font-size:13px;color:var(--muted);">ColocApp — Gérez votre colocation simplement</p>
</footer>

@stack('scripts')
</body>
</html>