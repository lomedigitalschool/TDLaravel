<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenue, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <!-- Message de succès -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('index') }}" class="mb-6 flex">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Rechercher une tâche..."
                class="w-full border rounded-l px-4 py-2"
            >
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700">
                Rechercher
            </button>
        </form>

        <!-- Lien de création -->
        <div class="mb-4">
            <a href="{{ route('todos.create') }}"
               class="bg-green-500 text-black px-4 py-2 rounded hover:bg-green-600">
                ➕ Nouvelle tâche
            </a>
        </div>

        <!-- Liste des tâches -->
        @forelse ($todos as $todo)
            <div class="bg-white shadow-md rounded p-4 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold {{ $todo->is_completed ? 'line-through text-gray-400' : '' }}">
                        {{ $todo->title }}
                    </h3>
                    <p class="text-gray-700 mb-1">{{ $todo->description }}</p>
                    <p class="text-sm text-gray-500">📅 Échéance : {{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->format('d/m/Y') : 'Non définie' }}</p>
                </div>

                <div class="mt-3 md:mt-0 flex space-x-2">
                    @if (!$todo->is_completed)
                        <form action="{{ route('todos.complete', $todo->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="text-green-600 hover:text-green-800">✔️ Compléter</button>
                        </form>
                    @endif

                    <a href="{{ route('todos.edit', $todo->id) }}"
                       class="text-blue-600 hover:text-blue-800">✏️ Modifier</a>

                    <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 hover:text-red-800">🗑️ Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                Aucune tâche trouvée.
            </div>
        @endforelse
    </div>
</x-app-layout>
