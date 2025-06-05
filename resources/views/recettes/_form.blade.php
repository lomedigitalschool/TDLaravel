<form method="POST" action="{{ isset($recette) ? route('recettes.update', $recette->id) : route('recettes.store') }}" enctype="multipart/form-data">
@csrf
@if(isset($recette))
    @method('PUT')
@endif

@csrf

<div class="space-y-6">
    <!-- Titre -->
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Titre *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $recette->title ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
               required
               minlength="3"
               @error('title') aria-invalid="true" aria-describedby="title-error" @enderror>
        @error('title')
            <p id="title-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description -->
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
        <textarea name="description" id="description" rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  required
                  minlength="10"
                  @error('description') aria-invalid="true" aria-describedby="description-error" @enderror>{{ old('description', $recette->description ?? '') }}</textarea>
        @error('description')
            <p id="description-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Ingrédients -->
    <div class="mb-4">
        <label for="ingredients" class="block text-sm font-medium text-gray-700">Ingrédients *</label>
        <textarea name="ingredients" id="ingredients" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  required
                  minlength="10"
                  @error('ingredients') aria-invalid="true" aria-describedby="ingredients-error" @enderror>{{ old('ingredients', $recette->ingredients ?? '') }}</textarea>
        @error('ingredients')
            <p id="ingredients-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Type et Temps -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Type de recette -->
        <div class="mb-4">
            <label for="type" class="block text-sm font-medium text-gray-700">Type de recette *</label>
            <select name="type" id="type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    required
                    @error('type') aria-invalid="true" aria-describedby="type-error" @enderror>
                <option value="">Sélectionnez un type</option>
                <option value="petit-déjeuner" {{ old('type', $recette->type ?? '') == 'petit-déjeuner' ? 'selected' : '' }}>Petit-déjeuner</option>
                <option value="déjeuner" {{ old('type', $recette->type ?? '') == 'déjeuner' ? 'selected' : '' }}>Déjeuner</option>
                <option value="dîner" {{ old('type', $recette->type ?? '') == 'dîner' ? 'selected' : '' }}>Dîner</option>
            </select>
            @error('type')
                <p id="type-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Temps de préparation -->
        <div class="mb-4">
            <label for="preparation_time" class="block text-sm font-medium text-gray-700">Temps (minutes) *</label>
            <input type="number" name="preparation_time" id="preparation_time"
                   value="{{ old('preparation_time', $recette->preparation_time ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                   min="1" max="600" required
                   @error('preparation_time') aria-invalid="true" aria-describedby="preparation_time-error" @enderror>
            @error('preparation_time')
                <p id="preparation_time-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Image -->
    <div class="mb-6">
    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
        Image de la recette
    </label>

    <!-- Zone de téléchargement -->
    <div class="flex items-center gap-4">
        <label for="image" class="cursor-pointer">
            <div class="px-4 py-2 bg-white border-2 border-dashed border-indigo-300 rounded-lg hover:border-indigo-500 transition-colors duration-200">
                <div class="flex flex-col items-center justify-center space-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm text-indigo-600 font-medium">Choisir une image</span>
                </div>
                <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage(event)">
            </div>
        </label>

        @if(isset($recette) && $recette->image_path)
            <button type="button" onclick="confirmDeleteImage()"
                    class="flex items-center text-sm text-red-600 hover:text-red-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd" />
                </svg>
                Supprimer
            </button>
        @endif
    </div>

    <!-- Aperçus -->
    <div class="mt-4 space-y-3">
        <!-- Image existante -->
        @if(isset($recette) && $recette->image_path)
            <div class="relative group" id="existing-image">
                <img src="{{ asset('storage/' . $recette->image_path) }}"
                     alt="Image actuelle de la recette"
                     class="rounded-lg shadow-md w-full h-48 object-cover border border-gray-200 aspect-video">
                <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="text-white font-medium">Image actuelle</span>
                </div>
            </div>
        @endif

        <!-- Aperçu de la nouvelle image -->
        <div id="image-preview-container" class="hidden relative group">
            <img id="image-preview" src="#" alt="Aperçu de la nouvelle image"
                 class="rounded-lg shadow-md w-full h-48 object-cover border border-gray-200 aspect-video">
            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="text-white font-medium">Nouvelle image</span>
            </div>
        </div>
    </div>

    <!-- Champ caché pour signaler la suppression -->
    @if(isset($recette) && $recette->image_path)
        <input type="hidden" name="remove_image" id="remove_image" value="0">
    @endif

    @error('image')
        <p class="mt-2 text-sm text-red-600 flex items-start">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                      clip-rule="evenodd" />
            </svg>
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');
    const container = document.getElementById('image-preview-container');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        // Si aucun fichier sélectionné (annulation)
        preview.src = '#';
        container.classList.add('hidden');
    }
}

function confirmDeleteImage() {
    if (confirm('Voulez-vous vraiment supprimer cette image ?')) {
        document.getElementById('remove_image').value = '1';

        const fileInput = document.querySelector('input[name="image"]');
        if (fileInput) fileInput.value = '';

        const existingImageDiv = document.getElementById('existing-image');
        if (existingImageDiv) existingImageDiv.classList.add('hidden');
    }
}
</script>


    <!-- Étapes -->
    <div class="mb-4">
        <label for="steps" class="block text-sm font-medium text-gray-700">Étapes de préparation *</label>
        <textarea name="steps" id="steps" rows="6"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  required
                  minlength="10"
                  @error('steps') aria-invalid="true" aria-describedby="steps-error" @enderror>{{ old('steps', $recette->steps ?? '') }}</textarea>
        @error('steps')
            <p id="steps-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Note -->
    <div class="mb-6">
    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Note</label>
    <div class="flex items-center space-x-2">
        <input type="number"
               name="rating"
               id="rating"
               min="1"
               max="5"
               value="{{ old('rating', $recette->rating ?? '') }}"
               class="block w-16 py-2 px-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-center font-medium text-amber-600"
               placeholder="0">
        <span class="text-gray-400 text-sm">/ 5 ★</span>
    </div>
    @error('rating')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

    <!-- Boutons -->
<div class="flex justify-end gap-4 pt-6 border-t border-gray-200 mt-6">
    <!-- Bouton Annuler - fond noir -->
    <a href="{{ route('recettes.index') }}"
       class="px-6 py-2.5 font-medium rounded-lg transition-all duration-300 ease-in-out
                   bg-black hover:bg-black text-white shadow-md hover:shadow-lg
                   focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2">
        <span class="flex items-center justify-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Annuler
        </span>
    </a>

    <!-- Bouton Enregistrer / Mettre à jour - fond rouge sans dégradé -->
    <button type="submit"
            class="px-6 py-2.5 font-medium rounded-lg transition-all duration-300 ease-in-out
                   bg-slate-900 hover:bg-slate-900 text-white shadow-md hover:shadow-lg
                   focus:outline-none focus:ring-2 focus:ring-slate-900 focus:ring-offset-2">
        <span class="flex items-center justify-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ isset($recette) ? 'Mettre à jour' : 'Enregistrer' }}
        </span>
    </button>
</div>



