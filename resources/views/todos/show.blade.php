{{-- resources/views/tasks/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-2xl p-4 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-4">Détail de la tâche</h1>

    <div class="mb-4">
        <label class="font-semibold">Titre :</label>
        <p class="text-gray-700">{{ $todo->title }}</p>
    </div>

    <div class="mb-4">
        <label class="font-semibold">Description :</label>
        <p class="text-gray-700">{{ $todo->description ?? 'Aucune description fournie.' }}</p>
    </div>

    <div class="mb-4">
        <label class="font-semibold">Statut :</label>
        <p class="text-gray-700">
            @if($todo->is_completed)
                <span class="text-green-600 font-medium">Terminée</span>
            @else
                <span class="text-red-600 font-medium">En cours</span>
            @endif
        </p>
    </div>

    <div class="mb-4">
        <label class="font-semibold">Date de création :</label>
        <p class="text-gray-700">{{ $task->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="flex space-x-4 mt-6">
        <a href="{{ route('todos.edit', $task) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Modifier
        </a>

        <form action="{{ route('todos.destroy', $task) }}" method="POST" onsubmit="return confirm('Supprimer cette tâche ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Supprimer
            </button>
        </form>

        <a href="{{ route('home') }}" class="ml-auto text-gray-600 hover:text-black underline">
            Retour à la liste
        </a>
    </div>
</div>
@endsection
