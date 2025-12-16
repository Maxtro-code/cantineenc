<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Réservation cantine
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Formulaire --}}
            <div class="bg-white p-6 rounded shadow">
                <form method="POST" action="{{ route('reservations.store') }}">
                    @csrf

                    <label class="block mb-2 font-semibold">Choisir une date</label>
                    <input type="date" name="date" class="border rounded px-3 py-2" required>

                    <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
                        Réserver
                    </button>
                </form>
            </div>

            {{-- Liste --}}
            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-4">Mes réservations</h3>

                @forelse($reservations as $reservation)
                    <p>📅 {{ $reservation->date }}</p>
                @empty
                    <p class="text-gray-500">Aucune réservation</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
