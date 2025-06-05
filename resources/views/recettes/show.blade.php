@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">{{ $recette->title }}</h1>

    <p class="text-gray-600 mb-2">
        <span class="font-semibold">Catégorie :</span> {{ ucfirst($recette->type) }}
    </p>

    @if ($recette->preparation_time)
        <p class="text-gray-600 mb-2">
            <span class="font-semibold">Temps de préparation :</span> {{ $recette->preparation_time }} minutes
        </p>
    @endif

    @if ($recette->rating)
        <p class="text-gray-600 mb-4">
            <span class="font-semibold">Note :</span>
            {{ str_repeat('⭐', $recette->rating) }} ({{ $recette->rating }}/5)
        </p>
    @endif

    @if ($recette->image_path)
        <div class="mb-6">
            <img src="{{ asset('storage/' . $recette->image_path) }}" alt="Image de la recette" class="rounded-lg shadow-md w-full">
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-2">Ingrédients</h2>
    <p class="mb-4 whitespace-pre-line">{{ $recette->ingredients }}</p>

    <h2 class="text-xl font-semibold mb-2">Étapes</h2>
    <p class="mb-6 whitespace-pre-line">{{ $recette->steps }}</p>

    @can('update', $recette)
    <div class="flex gap-4">
        <a href="{{ route('recettes.edit', $recette) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Modifier</a>

        <form action="{{ route('recettes.destroy', $recette) }}" method="POST" onsubmit="return confirm('Supprimer cette recette ?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Supprimer</button>
        </form>
    </div>
    @endcan
</div>
@endsection
