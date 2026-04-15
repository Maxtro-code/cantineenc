<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">📅 Mes Réservations</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Messages flash --}}
            @if (session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-xl font-semibold">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-xl font-semibold">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-700 text-sm rounded-r-xl font-semibold">
                    💡 {{ session('warning') }}
                </div>
            @endif

            {{-- Solde du compte --}}
            <div class="bg-white shadow rounded-2xl p-6 flex items-center justify-between gap-4">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Mon solde cantine</p>
                    <p class="text-3xl font-black {{ Auth::user()->solde < config('app.tarif_repas') ? 'text-red-500' : 'text-[#4a0d12]' }}">
                        {{ number_format(Auth::user()->solde, 2, ',', ' ') }} €
                    </p>
                    @if(Auth::user()->solde < config('app.tarif_repas'))
                        <p class="text-xs text-red-400 mt-1 font-semibold">
                            ⚠️ Solde insuffisant — rechargez votre compte ci-dessus.
                        </p>
                    @else
                        <p class="text-xs text-gray-400 mt-1">
                            Tarif repas : {{ number_format(config('app.tarif_repas'), 2, ',', ' ') }} €
                            · {{ floor(Auth::user()->solde / config('app.tarif_repas')) }} repas disponible(s)
                        </p>
                    @endif
                </div>
                <div class="flex flex-col items-end gap-3">
                    <div class="w-14 h-14 rounded-2xl bg-[#fff5f3] flex items-center justify-center text-2xl shrink-0">
                        💳
                    </div>
                    {{-- Recharge fictive --}}
                    <form method="POST" action="{{ route('reservations.recharger') }}" class="flex items-center gap-2">
                        @csrf
                        <input type="number" name="montant" min="0.01" max="500" step="0.01"
                               placeholder="Montant €" required
                               class="w-28 border border-gray-200 rounded-xl px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-[#f53003] text-center">
                        <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-green-700 transition shadow">
                            + Recharger
                        </button>
                    </form>
                </div>
            </div>

            {{-- Formulaire nouvelle réservation --}}
            <div class="bg-white shadow rounded-2xl p-6">
                <h3 class="font-bold text-[#4a0d12] text-base mb-5">Nouvelle réservation</h3>
                <form method="POST" action="{{ route('reservations.store') }}" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Date du repas</label>
                        <input type="date"
                               name="date"
                               min="{{ date('Y-m-d') }}"
                               value="{{ request('date', old('date')) }}"
                               required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#f53003] transition">
                        <p class="text-xs text-gray-400 mt-1">
                            Lundi au vendredi · {{ number_format(config('app.tarif_repas'), 2, ',', ' ') }} € débités à la réservation
                        </p>
                        @error('date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="px-6 py-3 bg-[#4a0d12] text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition shadow">
                            Réserver
                        </button>
                    </div>
                </form>
            </div>

            {{-- Liste des réservations --}}
            <div class="bg-white shadow rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="font-bold text-[#4a0d12] text-base">
                        Mes réservations
                        <span class="ml-2 text-sm text-gray-400 font-normal">({{ $reservations->count() }} total)</span>
                    </h3>
                    @if($reservations->count())
                        <span class="text-xs text-gray-400">
                            Total dépensé : <strong class="text-[#4a0d12]">{{ number_format($reservations->sum('montant'), 2, ',', ' ') }} €</strong>
                        </span>
                    @endif
                </div>

                @if ($reservations->isEmpty())
                    <div class="p-12 text-center text-gray-400 text-sm">
                        Aucune réservation pour le moment.
                    </div>
                @else
                    <ul class="divide-y divide-gray-50">
                        @foreach ($reservations as $reservation)
                            @php
                                $date     = \Carbon\Carbon::parse($reservation->date);
                                $estPasse = $date->isPast() && !$date->isToday();
                            @endphp
                            <li class="flex items-center justify-between px-6 py-4 {{ $estPasse ? 'opacity-50' : '' }}">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">{{ $date->isToday() ? '🍴' : ($estPasse ? '✓' : '📅') }}</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ $date->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($date->isToday())
                                                <span class="text-[10px] font-bold uppercase bg-[#f53003] text-white px-2 py-0.5 rounded-full">Aujourd'hui</span>
                                            @elseif($date->isTomorrow())
                                                <span class="text-[10px] font-bold uppercase bg-[#f8b803] text-[#4a0d12] px-2 py-0.5 rounded-full">Demain</span>
                                            @elseif($estPasse)
                                                <span class="text-[10px] text-gray-400">Passé</span>
                                            @endif
                                            <span class="text-[10px] text-gray-400 font-semibold">
                                                {{ number_format($reservation->montant, 2, ',', ' ') }} €
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @if(!$estPasse)
                                    <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                                          onsubmit="return confirm('Annuler ce repas ? Le montant sera remboursé.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-400 hover:text-red-600 font-semibold transition px-3 py-1 rounded-lg hover:bg-red-50">
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
