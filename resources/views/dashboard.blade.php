<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    Bienvenue, {{ Auth::user()->name }} !!
                </h3>

                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Vous êtes dans votre journal personnel.
                </p>

                <div class="space-y-4">
                    <a href="{{ route('journal.index') }}"
                       class="block bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                        Voir mes entrées de journal
                    </a>

                    <a href="{{ route('journal.create') }}"
                       class="block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                        Ajouter une nouvelle entrée
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                        Modifier mon profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


