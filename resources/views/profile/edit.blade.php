<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier mon profil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Formulaire pour mettre à jour le nom et l'email --}}
            <form method="POST" action="{{ route('profile.update') }}" class="bg-white p-6 shadow-sm sm:rounded-lg">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block font-medium text-sm text-gray-700">Nom</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mt-4">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>

            {{-- Formulaire pour changer le mot de passe --}}
            <form method="POST" action="{{ route('password.update') }}" class="bg-white p-6 shadow-sm sm:rounded-lg mt-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block font-medium text-sm text-gray-700">Mot de passe actuel</label>
                    <input type="password" name="current_password" id="current_password"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mt-4">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700">
                        Mettre à jour le mot de passe
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
