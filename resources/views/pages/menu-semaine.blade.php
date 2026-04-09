<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🍽️ Menu de la semaine {{ $semaine }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                @foreach($jours as $jour => $repas)
                    @php $estAujourdHui = $jour === $jourCourant; @endphp
                    <div class="rounded-2xl shadow overflow-hidden flex flex-col
                        {{ $estAujourdHui ? 'ring-2 ring-[#f53003] bg-white' : 'bg-white' }}">

                        {{-- En-tête du jour --}}
                        <div class="px-4 py-3 {{ $estAujourdHui ? 'bg-[#4a0d12]' : 'bg-gray-50' }} border-b">
                            <p class="font-black text-sm uppercase tracking-widest {{ $estAujourdHui ? 'text-[#f8b803]' : 'text-gray-600' }}">
                                {{ $jour }}
                            </p>
                            @if($estAujourdHui)
                                <span class="text-[10px] text-white opacity-70">Aujourd'hui</span>
                            @endif
                            @if($repas['vegetarien'])
                                <span class="inline-block text-[9px] font-bold uppercase bg-green-100 text-green-700 px-1.5 py-0.5 rounded mt-1">
                                    🌿 Végétarien
                                </span>
                            @endif
                        </div>

                        {{-- Contenu --}}
                        <div class="p-4 flex-1 space-y-3">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Entrée</p>
                                <p class="text-sm text-gray-700">{{ $repas['entree'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Plat</p>
                                <p class="text-sm font-semibold text-[#4a0d12]">{{ $repas['plat'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Dessert</p>
                                <p class="text-sm text-gray-700">{{ $repas['dessert'] }}</p>
                            </div>
                        </div>

                        {{-- Bouton réservation rapide --}}
                        <div class="px-4 pb-4">
                            @php
                                $dateJour = \Carbon\Carbon::now()->startOfWeek()->addDays(array_search($jour, array_keys($jours)));
                                $peutReserver = $dateJour->isFuture() || $dateJour->isToday();
                            @endphp
                            @if($peutReserver)
                                <a href="{{ route('reservations.index') }}?date={{ $dateJour->format('Y-m-d') }}"
                                   class="block text-center text-[10px] font-bold uppercase tracking-widest px-3 py-2 rounded-xl
                                   {{ $estAujourdHui ? 'bg-[#f53003] text-white hover:bg-[#d42800]' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                                    Réserver
                                </a>
                            @else
                                <p class="text-center text-[10px] text-gray-300 font-bold uppercase py-2">Passé</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Note d'information --}}
            <p class="mt-8 text-xs text-gray-400 text-center italic">
                * Les menus sont susceptibles d'être modifiés. Consultez la page régulièrement.
                En cas d'allergie, contactez : <a href="mailto:restauration@enc-bessieres.org" class="underline">restauration@enc-bessieres.org</a>
            </p>
        </div>
    </div>
</x-app-layout>
