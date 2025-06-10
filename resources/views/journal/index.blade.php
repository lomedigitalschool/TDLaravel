<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Mes entrées du journal') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">
        <a href="{{ route('journal.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Nouvelle entrée</a>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @forelse($entries as $entry)
            <div class="bg-white shadow p-6 rounded mb-6">
                <h3 class="text-2xl font-bold">{{ $entry->titre }}</h3>
                
                @if($entry->image)
                    <img src="{{ asset('storage/' . $entry->image) }}" alt="Image" class="my-4 rounded-md">
                @endif

                <p class="mb-2"><strong>Contenu :</strong> {{ Str::limit($entry->contenu, 100) }}</p>
                <p class="mb-2"><strong>Humeur :</strong> {{ ucfirst($entry->humeur ?? 'Non spécifiée') }}</p>
                <p class="mb-2"><strong>Visibilité :</strong> {{ $entry->est_public ? 'Public' : 'Privé' }}</p>

                <div class="mt-4 flex gap-3">
                    <a href="{{ route('journal.show', $entry->id) }}" class="text-blue-600 underline">Voir</a>
                    <a href="{{ route('journal.edit', $entry->id) }}" class="text-yellow-600 underline">Modifier</a>

                    <form action="{{ route('journal.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Supprimer cette entrée ?');" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 underline">Supprimer</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-600">Aucune entrée trouvée pour le moment.</p>
        @endforelse
    </div>
</x-app-layout>


