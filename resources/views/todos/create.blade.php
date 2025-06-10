@extends('layout')

@section('title', 'Créer une tâche')

@section('content')
    <h1 class="text-2xl font-bold mb-6">➕ Nouvelle tâche</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('todos.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <div>
            <label for="title" class="block text-sm font-medium">Titre</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded-md">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('home') }}" class="text-gray-500 mr-4 hover:underline">Annuler</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer</button>
        </div>
    </form>
@endsection
