@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Mes Recettes</h1>
        <a href="{{ route('recettes.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            + Nouvelle Recette
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($recettes->isEmpty())
        <p class="text-gray-500">Vous n'avez encore ajouté aucune recette.</p>
    @else
        <div class="grid md:grid-cols-2 gap-6">
            @foreach ($recettes as $recette)
                <div class="bg-white rounded-lg shadow-md p-4">
                    @if ($recette->image_path)
                        <img src="{{ asset('storage/' . $recette->image_path) }}" alt="{{ $recette->title }}" class="rounded-md mb-3 w-full h-48 object-cover">
                    @endif

                    <h2 class="text-xl font-semibold">{{ $recette->title }}</h2>

                    @if ($recette->preparation_time)
                        <p class="text-gray-600 text-sm mb-1">⏱ {{ $recette->preparation_time }} min</p>
                    @endif

                    <p class="text-gray-700 text-sm line-clamp-3">{{ Str::limit($recette->description, 100) }}</p>

                    <div class="mt-4 flex justify-between items-center">
                        <a href="{{ route('recettes.show', $recette) }}" class="text-blue-600 hover:underline">Voir plus</a>

                        @can('update', $recette)
                        <div class="flex items-center gap-2">
                            <a href="{{ route('recettes.edit', $recette) }}" class="text-sm text-blue-500 hover:underline">Modifier</a>

                            <!-- Confirmation Modal Component -->
                            <x-confirmation-modal
                                id="modal-{{ $recette->id }}"
                                :action="route('recettes.destroy', $recette)"
                                method="DELETE"
                                title="Supprimer la recette"
                                message="Es-tu sûr de vouloir supprimer cette recette ? Cette action est irréversible."
                                confirm-text="Oui, supprimer"
                                cancel-text="Annuler"
                            />
                        </div>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if (session('success'))
    <script>
        setTimeout(function () {
            window.location.reload();
        }, 2000); // 2000 ms = 2 secondes
    </script>
@endif
</div>



@endsection
