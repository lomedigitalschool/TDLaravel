<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Détail du journal') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-4">{{ $journalEntry->titre }}</h1>

            @if ($journalEntry->image)
                <img src="{{ asset('storage/' . $journalEntry->image) }}" alt="Image" class="mb-4 rounded-md">
            @endif

            <p><strong>Contenu :</strong></p>
            <p class="mb-4">{{ $journalEntry->contenu }}</p>

            <p><strong>Humeur :</strong> {{ ucfirst($journalEntry->humeur ?? 'Non spécifiée') }}</p>
            <p><strong>Visibilité :</strong> {{ $journalEntry->est_public ? 'Public' : 'Privé' }}</p>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('journal.edit', $journalEntry->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Modifier</a>

                <form action="{{ route('journal.destroy', $journalEntry->id) }}" method="POST" onsubmit="return confirm('Supprimer cette entrée ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
