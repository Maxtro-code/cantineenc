<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenue, {{ Auth::user()->name }} 👋
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Message flash --}}
            @if (session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-xl font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Cartes rapides --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <a href="{{ route('menu.semaine') }}"
                   class="bg-white rounded-2xl shadow p-6 flex flex-col items-start gap-3 hover:shadow-md transition group border border-transparent hover:border-[#f53003]">
                    <span class="text-3xl">🍽️</span>
                    <div>
                        <p class="font-bold text-[#4a0d12] text-base group-hover:text-[#f53003] transition">Menu de la semaine</p>
                        <p class="text-xs text-gray-400 mt-1">Consulter les repas de la semaine</p>
                    </div>
                </a>

                <a href="{{ route('reservations.index') }}"
                   class="bg-white rounded-2xl shadow p-6 flex flex-col items-start gap-3 hover:shadow-md transition group border border-transparent hover:border-[#f53003]">
                    <span class="text-3xl">📅</span>
                    <div>
                        <p class="font-bold text-[#4a0d12] text-base group-hover:text-[#f53003] transition">Mes réservations</p>
                        <p class="text-xs text-gray-400 mt-1">Gérer mes repas réservés</p>
                    </div>
                </a>

                <a href="{{ route('profile.show') }}"
                   class="bg-white rounded-2xl shadow p-6 flex flex-col items-start gap-3 hover:shadow-md transition group border border-transparent hover:border-[#f53003]">
                    <span class="text-3xl">👤</span>
                    <div>
                        <p class="font-bold text-[#4a0d12] text-base group-hover:text-[#f53003] transition">Mon profil</p>
                        <p class="text-xs text-gray-400 mt-1">Modifier mes informations</p>
                    </div>
                </a>
            </div>

            {{-- Prochaines réservations --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h3 class="font-bold text-[#4a0d12] text-base mb-4">📋 Prochains repas réservés</h3>
                @if($prochaines->isEmpty())
                    <p class="text-sm text-gray-400 italic">Aucune réservation à venir.
                        <a href="{{ route('reservations.index') }}" class="text-[#f53003] font-bold hover:underline ml-1">Réserver maintenant →</a>
                    </p>
                @else
                    <ul class="divide-y divide-gray-50">
                        @foreach($prochaines as $r)
                            <li class="py-3 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 rounded-xl bg-[#fff5f3] flex items-center justify-center text-lg">🍴</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ \Carbon\Carbon::parse($r->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                                        </p>
                                        @if(\Carbon\Carbon::parse($r->date)->isToday())
                                            <span class="text-[10px] font-bold uppercase bg-[#f53003] text-white px-2 py-0.5 rounded-full">Aujourd'hui</span>
                                        @elseif(\Carbon\Carbon::parse($r->date)->isTomorrow())
                                            <span class="text-[10px] font-bold uppercase bg-[#f8b803] text-[#4a0d12] px-2 py-0.5 rounded-full">Demain</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('reservations.index') }}" class="text-xs text-gray-400 hover:text-[#f53003]">Gérer →</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Informations pratiques --}}
            <div class="bg-[#4a0d12] text-white rounded-2xl shadow p-6 flex flex-col sm:flex-row gap-6 items-start sm:items-center justify-between">
                <div>
                    <p class="font-bold text-[#f8b803] uppercase tracking-widest text-xs mb-2">Infos pratiques</p>
                    <p class="text-sm">Cantine ouverte du lundi au vendredi · 11h30 – 13h30</p>
                    <p class="text-sm text-gray-300 mt-1">Contact : <a href="mailto:restauration@enc-bessieres.org" class="underline hover:text-[#f8b803]">restauration@enc-bessieres.org</a></p>
                </div>
                <a href="{{ route('menu.semaine') }}"
                   class="shrink-0 px-5 py-3 bg-[#f8b803] text-[#4a0d12] text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-yellow-400 transition">
                    Voir le menu →
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
