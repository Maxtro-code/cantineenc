<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un utilisateur de la Cantine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form method="POST" action="{{ route('creation-etudiant') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="col-span-1">
                            <x-label for="nom" value="{{ __('Nom de l\'utilisateur') }}" />
                            <x-input id="nom" name="nom" type="text" class="mt-1 block w-full" required />
                            <x-input-error for="nom" class="mt-2" />
                        </div>

                        <div class="col-span-1">
                            <x-label for="email" value="{{ __('Adresse Email') }}" />
                            <x-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                            <x-input-error for="email" class="mt-2" />
                        </div>

                        <div class="col-span-1">
                            <x-label for="telephone" value="{{ __('Numéro de Téléphone') }}" />
                            <x-input id="telephone" name="numero_telephone" type="tel" class="mt-1 block w-full" />
                            <x-input-error for="numero_telephone" class="mt-2" />
                        </div>

                        <div class="col-span-1">
                            <x-label for="date_entree" value="{{ __('Date d\'entrée à l\'ENC') }}" />
                            <x-input id="date_entree" name="date_entree_enc" type="date" class="mt-1 block w-full" />
                            <x-input-error for="date_entree_enc" class="mt-2" />
                        </div>

                        <div class="col-span-1">
                            <x-label for="section" value="{{ __('Section') }}" />
                            <select id="section" name="section" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Sélectionner une section --</option>
                                <option value="BTS SIO">BTS SIO</option>
                                <option value="Autres formations">Autres formations</option>
                            </select>
                            <x-input-error for="section" class="mt-2" />
                        </div>


                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-button class="ml-4">
                            {{ __('Enregistrer l\'utilisateur') }}
                        </x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
