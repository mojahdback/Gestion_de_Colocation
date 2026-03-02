<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ColocApp') — ColocApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .flash-success { @apply bg-green-50 border border-green-200 text-green-800; }
        .flash-error   { @apply bg-red-50 border border-red-200 text-red-800; }
        .flash-info    { @apply bg-blue-50 border border-blue-200 text-blue-800; }
    </style>
</head>
<body class="h-full">

<!-- Navbar -->
<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-indigo-600">🏠 ColocApp</a>
                @auth
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">
                            Ma colocation
                        </a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-orange-600 hover:text-orange-700 transition">
                                ⚙️ Admin
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            @auth
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-semibold text-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="hidden sm:block text-sm text-gray-700">{{ auth()->user()->name }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ auth()->user()->reputation >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ auth()->user()->reputation >= 0 ? '+' : '' }}{{ auth()->user()->reputation }}
                    </span>
                </div>
                <a href="{{ route('profile.edit') }}" class="text-sm text-gray-500 hover:text-gray-700">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600 transition">Déconnexion</button>
                </form>
            </div>
            @else
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600">Connexion</a>
                <a href="{{ route('register') }}" class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">S'inscrire</a>
            </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    @foreach(['success', 'error', 'info'] as $type)
        @if(session($type))
            <div class="flash-{{ $type }} px-4 py-3 rounded-lg mb-4 flex items-center justify-between" id="flash-{{ $type }}">
                <span>{{ session($type) }}</span>
                <button onclick="document.getElementById('flash-{{ $type }}').remove()" class="ml-4 opacity-60 hover:opacity-100">✕</button>
            </div>
        @endif
    @endforeach

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @yield('content')
</main>

<!-- Footer -->
<footer class="mt-16 border-t border-gray-200 py-6">
    <p class="text-center text-sm text-gray-400">ColocApp — Gérez votre colocation simplement</p>
</footer>

@stack('scripts')
</body>
</html>
