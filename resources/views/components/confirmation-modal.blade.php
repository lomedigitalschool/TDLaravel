<!-- resources/views/components/confirmation-modal.blade.php -->

@props(['action', 'method' => 'POST', 'confirmText' => 'Confirmer'])


<div x-data="{ open: false }" class="inline-block">
    <!-- Bouton pour ouvrir la modale -->
    <button @click="open = true" class="{{ $triggerClass ?? 'text-red-600 hover:underline' }}">
        {{ $triggerText ?? 'Supprimer' }}
    </button>

    <!-- Modale -->
    <template x-if="open">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-sm">
                <h2 class="text-lg font-semibold text-gray-800">{{ $title ?? 'Confirmation' }}</h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $message ?? 'Es-tu sûr de vouloir effectuer cette action ?' }}
                </p>

                <div class="mt-4 flex justify-end space-x-3">
                    <button @click="open = false" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Annuler
                    </button>

                    <form method="POST" action="{{ $action }}">
                        @csrf
                        @method($method ?? 'POST')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            {{ $confirmText ?? 'Confirmer' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>
