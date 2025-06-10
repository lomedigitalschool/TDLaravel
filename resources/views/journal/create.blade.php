<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nouvelle entrée de journal
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('journal.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="titre" class="block font-semibold">Titre</label>
                        <input type="text" name="titre" id="titre" required class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label for="contenu" class="block font-semibold">Contenu</label>
                        <textarea name="contenu" id="contenu" rows="5" required class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="humeur" class="block font-semibold">Humeur du jour</label>
                        <select name="humeur" id="humeur" class="w-full border rounded px-3 py-2">
                            <option value="">-- Choisir --</option>
                            <option value="heureuse">Heureuse</option>
                            <option value="triste">Triste</option>
                            <option value="stressée">Stressée</option>
                            <option value="motivé">Motivée</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block font-semibold">Image</label>
                        <input type="file" name="image" id="image" class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Visibilité</label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="visibilite" value="publique" class="mr-2"> Publique
                        </label>
                        <label class="inline-flex items-center ml-4">
                            <input type="radio" name="visibilite" value="privee" checked class="mr-2"> Privée
                        </label>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Enregistrer l’entrée
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
