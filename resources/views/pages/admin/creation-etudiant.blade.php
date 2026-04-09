<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">⚙️ Administration · Gestion des utilisateurs</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ─── MESSAGES FLASH ──────────────────────────────────────── --}}
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

            {{-- ─── MOT DE PASSE TEMPORAIRE (affiché UNE SEULE FOIS) ────── --}}
            @if (session('temp_password'))
                <div class="p-5 bg-amber-50 border-2 border-amber-400 rounded-2xl">
                    <p class="text-xs font-bold uppercase tracking-widest text-amber-700 mb-3">
                        🔑 Mot de passe temporaire généré — À communiquer maintenant (affiché une seule fois)
                    </p>
                    <div class="flex items-center gap-4 flex-wrap">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Email</p>
                            <code class="font-mono font-bold text-[#4a0d12] text-sm bg-white px-3 py-1.5 rounded-lg border">{{ session('new_user_email') }}</code>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Mot de passe temporaire</p>
                            <code class="font-mono font-bold text-[#f53003] text-lg bg-white px-4 py-2 rounded-lg border-2 border-amber-300 tracking-widest">{{ session('temp_password') }}</code>
                        </div>
                    </div>
                    <p class="text-xs text-amber-600 mt-3 italic">
                        ⚠️ L'utilisateur devra changer son mot de passe lors de sa première connexion (via Mon profil → Changer le mot de passe).
                    </p>
                </div>
            @endif

            {{-- ─── FORMULAIRE CRÉATION D'UTILISATEUR ──────────────────── --}}
            <div class="bg-white shadow rounded-2xl p-6">
                <h3 class="font-bold text-[#4a0d12] text-base mb-1">Créer un compte utilisateur</h3>
                <p class="text-xs text-gray-400 mb-6">
                    Un mot de passe temporaire conforme aux recommandations ANSSI sera généré automatiquement.
                    Règle de login : <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[#f53003]">prenom.nom@enc-bessieres.org</code>
                </p>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Nom complet *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Marie Dupont"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#f53003] transition">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">Email académique *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="marie.dupont@enc-bessieres.org"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#f53003] transition">
                            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                        class="w-4 h-4 rounded accent-[#f53003]">
                        <label for="is_admin" class="text-sm text-gray-600 font-medium">
                            Accorder les droits <span class="font-bold text-[#4a0d12]">Administrateur</span>
                            <span class="text-xs text-gray-400">(accès à ce panneau)</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <p class="text-xs text-gray-400">* Champs obligatoires</p>
                        <button type="submit"
                                class="px-7 py-3 bg-[#4a0d12] text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition shadow">
                            Créer le compte →
                        </button>
                    </div>
                </form>
            </div>

            {{-- ─── LISTE DES UTILISATEURS ──────────────────────────────── --}}
            <div class="bg-white shadow rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
                    <h3 class="font-bold text-[#4a0d12] text-base">
                        Utilisateurs inscrits
                        <span class="ml-2 text-sm text-gray-400 font-normal">({{ $users->count() }})</span>
                    </h3>
                    <span class="text-xs text-gray-400">{{ $users->where('is_admin', true)->count() }} admin(s)</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                        <tr>
                            <th class="px-6 py-3 text-left">Nom</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-center">Rôle</th>
                            <th class="px-6 py-3 text-center">Inscrit le</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50/50 transition {{ $user->id === auth()->id() ? 'bg-amber-50/30' : '' }}">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-1 text-[10px] text-gray-400">(vous)</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($user->is_admin)
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase bg-[#f8b803] text-[#4a0d12] rounded-full">Admin</span>
                                    @else
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase bg-gray-100 text-gray-500 rounded-full">Utilisateur</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-gray-400 text-xs">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Basculer admin --}}
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                        class="text-xs px-3 py-1.5 rounded-lg font-semibold transition
                                                            {{ $user->is_admin
                                                                ? 'bg-amber-50 text-amber-700 hover:bg-amber-100'
                                                                : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                                        title="{{ $user->is_admin ? 'Retirer les droits admin' : 'Promouvoir admin' }}">
                                                    {{ $user->is_admin ? '↓ Rétrograder' : '↑ Admin' }}
                                                </button>
                                            </form>

                                            {{-- Supprimer --}}
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                  onsubmit="return confirm('Supprimer le compte de {{ $user->name }} ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="text-xs px-3 py-1.5 rounded-lg font-semibold bg-red-50 text-red-500 hover:bg-red-100 transition">
                                                    Supprimer
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-300 italic">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
