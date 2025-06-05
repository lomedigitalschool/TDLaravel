@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Nouvelle recette</h1>
    <form action="{{ route('recettes.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        @include('recettes._form', ['submitLabel' => 'Créer'])
    </form>
</div>
@endsection
