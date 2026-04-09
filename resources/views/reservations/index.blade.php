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
                        <p class="text-xs text-gray-400 mt-1">Lundi au vendredi uniquement</p>
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
                </div>

                @if ($reservations->isEmpty())
                    <div class="p-12 text-center text-gray-400 text-sm">
                        Aucune réservation pour le moment.
                    </div>
                @else
                    <ul class="divide-y divide-gray-50">
                        @foreach ($reservations as $reservation)
                            @php
                                $date = \Carbon\Carbon::parse($reservation->date);
                                $estPasse = $date->isPast() && !$date->isToday();
                            @endphp
                            <li class="flex items-center justify-between px-6 py-4 {{ $estPasse ? 'opacity-50' : '' }}">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">{{ $date->isToday() ? '🍴' : ($estPasse ? '✓' : '📅') }}</span>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ $date->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                                        </p>
                                        @if($date->isToday())
                                            <span class="text-[10px] font-bold uppercase bg-[#f53003] text-white px-2 py-0.5 rounded-full">Aujourd'hui</span>
                                        @elseif($date->isTomorrow())
                                            <span class="text-[10px] font-bold uppercase bg-[#f8b803] text-[#4a0d12] px-2 py-0.5 rounded-full">Demain</span>
                                        @elseif($estPasse)
                                            <span class="text-[10px] text-gray-400">Passé</span>
                                        @endif
                                    </div>
                                </div>
                                @if(!$estPasse)
                                    <form method="POST" action="{{ route('reservations.destroy', $reservation) }}"
                                          onsubmit="return confirm('Annuler ce repas ?')">
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
