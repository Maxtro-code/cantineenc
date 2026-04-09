<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">ℹ️ Informations · Restauration scolaire</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Horaires et tarifs --}}
            <div class="bg-white shadow rounded-2xl p-6">
                <h3 class="font-bold text-[#4a0d12] text-base mb-5">🕐 Horaires & Tarifs</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Service du midi</p>
                        <p class="font-semibold text-gray-800">11h30 – 13h30</p>
                        <p class="text-xs text-gray-500 mt-1">Du lundi au vendredi (hors vacances scolaires)</p>
                    </div>
                    <div class="bg-[#fff5f3] rounded-xl p-4 border border-[#f53003]/10">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2">Tarif repas</p>
                        <p class="font-bold text-2xl text-[#4a0d12]">4,50 €</p>
                        <p class="text-xs text-gray-500 mt-1">Entrée + Plat + Dessert</p>
                    </div>
                </div>
            </div>

            {{-- Comment réserver --}}
            <div class="bg-white shadow rounded-2xl p-6">
                <h3 class="font-bold text-[#4a0d12] text-base mb-5">📋 Comment réserver un repas ?</h3>
                <ol class="space-y-4">
                    @foreach([
                        ['🔐', 'Connexion', 'Connectez-vous avec vos identifiants académiques fournis par l\'administration.'],
                        ['🍽️', 'Consultation du menu', 'Consultez le menu de la semaine via l\'onglet « Menu Semaine ».'],
                        ['📅', 'Réservation', 'Rendez-vous dans « Mes Réservations » et sélectionnez la date souhaitée.'],
                        ['✅', 'Confirmation', 'Votre réservation est enregistrée. Elle apparaît dans votre liste.'],
                        ['🏫', 'Le jour J', 'Présentez-vous à la cantine avec votre badge étudiant entre 11h30 et 13h30.'],
                    ] as [$icon, $titre, $texte])
                        <li class="flex gap-4 items-start">
                            <span class="shrink-0 w-9 h-9 rounded-xl bg-[#fff5f3] flex items-center justify-center text-lg">{{ $icon }}</span>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $titre }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $texte }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Règlement --}}
            <div class="bg-white shadow rounded-2xl p-6">
                <h3 class="font-bold text-[#4a0d12] text-base mb-4">📜 Règlement intérieur</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex gap-2"><span class="text-[#f8b803]">●</span> La réservation doit être effectuée avant la veille à 22h.</li>
                    <li class="flex gap-2"><span class="text-[#f8b803]">●</span> Toute réservation non honorée sans annulation préalable sera facturée.</li>
                    <li class="flex gap-2"><span class="text-[#f8b803]">●</span> Le badge étudiant est obligatoire pour accéder au service.</li>
                    <li class="flex gap-2"><span class="text-[#f8b803]">●</span> Les allergies alimentaires doivent être signalées à l'avance par email.</li>
                </ul>
            </div>

            {{-- Contact --}}
            <div class="bg-[#4a0d12] text-white rounded-2xl p-6 flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                <div>
                    <p class="font-bold text-[#f8b803] uppercase tracking-widest text-xs mb-1">Contact cantine</p>
                    <a href="mailto:restauration@enc-bessieres.org" class="text-sm hover:underline hover:text-[#f8b803] transition">
                        restauration@enc-bessieres.org
                    </a>
                </div>
                <a href="{{ route('reservations.index') }}"
                   class="shrink-0 px-5 py-3 bg-[#f8b803] text-[#4a0d12] text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-yellow-400 transition">
                    Réserver maintenant →
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
