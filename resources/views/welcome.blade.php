<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur le Gestionnaire de Tâches</h1>
        <p class="text-gray-600 mb-6">Gérez vos tâches efficacement en vous connectant à votre compte.</p>
        <a href="{{ route('login') }}"
           class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            Se connecter
        </a>
    </div>
</body>
</html>
