@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Modifier la recette</h1>

    <form action="{{ route('recettes.update', $recette) }}" method="POST">
        @csrf
        @method('PUT')

        @include('recettes._form', ['submitLabel' => 'Mettre à jour'])
        @if (session('success'))
          <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
          </div>
        @endif

    </form>
</div>
@endsection
