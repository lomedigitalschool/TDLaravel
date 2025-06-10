<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Infos sur le profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mets à jour ton profil utilisateur avec tes informations personnelles.") }}
        </p>
    </header>

    <!-- FORMULAIRE UNIQUE -->
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nom -->
        <div>
            <x-input-label for="name" value="Nom" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Clique ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Photo de profil -->
        <div>
            <x-input-label for="profile_photo" value="Photo de profil" />
            <input id="profile_photo" name="profile_photo" type="file" accept="image/*" class="mt-1 block w-full">
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />

            @if ($user->profile_photo)
                <div class="mt-4">
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo de profil"
                        class="w-24 h-24 rounded-full object-cover">
                </div>
            @endif
        </div>

        <!-- Bouton de validation -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Modifications enregistrées.') }}
                </p>
            @endif
        </div>
    </form>

    <!-- Formulaire caché pour renvoi de l’email de vérification -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
        @csrf
    </form>
</section>
