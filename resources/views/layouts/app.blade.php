<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Carnet de Recettes') }}</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>

</head>
<body class="bg-gray-100 text-gray-800 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('recettes.index') }}" class="text-2xl font-bold text-green-600">Carnet de Recettes</a>

            <div class="flex items-center gap-4">
                @auth
                    <span class="text-sm">Bonjour, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:underline">Déconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-blue-500 hover:underline">Connexion</a>
                    <a href="{{ route('register') }}" class="text-sm text-blue-500 hover:underline">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Contenu principal --}}
    <main class="py-10">
        <div class="max-w-6xl mx-auto px-4">
            {{-- Flash message global --}}
            @if (session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 shadow">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6 shadow">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Contenu spécifique à chaque vue --}}
            @yield('content')
        </div>
    </main>

    {{-- Pied de page --}}
    <footer class="bg-white shadow-inner py-4 mt-12">
        <div class="text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Carnet de Recettes · Développé avec Laravel & Tailwind
        </div>
    </footer>

</body>
</html>
