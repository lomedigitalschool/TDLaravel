@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Modifier l’entrée</h2>

        <form action="{{ route('journal.update', $journalEntry) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <p>
                <label for="titre">Titre :</label><br>
                <input type="text" name="titre" id="titre" value="{{ $journalEntry->titre }}" required style="width: 100%;">
            </p>

            <p>
                <label for="contenu">Contenu :</label><br>
                <textarea name="contenu" id="contenu" rows="5" required style="width: 100%;">{{ $journalEntry->contenu }}</textarea>
            </p>

            <p>
                <label for="humeur">Humeur :</label><br>
                <select name="humeur" id="humeur" style="width: 100%;">
                    <option value="">-- Choisir --</option>
                    @foreach(['heureux', 'triste', 'stressé', 'fatigué', 'motivé'] as $humeur)
                        <option value="{{ $humeur }}" {{ $journalEntry->humeur === $humeur ? 'selected' : '' }}>
                            {{ ucfirst($humeur) }}
                        </option>
                    @endforeach
                </select>
            </p>

            <p>
                <label for="image">Image (optionnelle) :</label><br>
                <input type="file" name="image" id="image"><br>
                @if($journalEntry->image)
                    <img src="{{ asset('storage/' . $journalEntry->image) }}" alt="Image" style="max-width: 150px; margin-top: 5px;">
                @endif
            </p>

            <p>
                <label>
                    <input type="checkbox" name="est_public" id="est_public" {{ $journalEntry->est_public ? 'checked' : '' }}>
                    Rendre cette entrée publique
                </label>
            </p>

            <p>
                <button type="submit">Mettre à jour</button>
            </p>
        </form>
    </div>
@endsection
