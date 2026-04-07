<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Réservations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages flash --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Formulaire ajout réservation --}}
            <div class="bg-white shadow rounded-2xl p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Nouvelle réservation</h3>
                <form method="POST" action="{{ route('reservations.store') }}" class="flex flex-col sm:flex-row gap-4">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Date</label>
                        <input type="date"
                               name="date"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('date') }}"
                               required
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-red-400 transition">
                        @error('date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="px-6 py-3 bg-red-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-red-700 transition shadow">
                            Réserver
                        </button>
                    </div>
                </form>
            </div>

            {{-- Liste des réservations --}}
            <div class="bg-white shadow rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-700">Mes réservations ({{ $reservations->count() }})</h3>
                </div>
                @if ($reservations->isEmpty())
                    <div class="p-12 text-center text-gray-400 text-sm">
                        Aucune réservation pour le moment.
                    </div>
                @else
                    <ul class="divide-y divide-gray-50">
                        @foreach ($reservations as $reservation)
                            <li class="flex items-center justify-between px-6 py-4">
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $reservation->date->translatedFormat('l d F Y') }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    Réservé le {{ $reservation->created_at->format('d/m/Y') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
