<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo / Marque -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-baseline gap-1.5">
                        <span class="text-[#f8b803] font-black text-xl italic tracking-tighter">ENC</span>
                        <span class="text-[#f53003] font-black text-xl uppercase tracking-tighter">Bessières</span>
                    </a>
                </div>

                <!-- Liens de navigation desktop -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex items-center">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        🏠 Accueil
                    </x-nav-link>
                    <x-nav-link href="{{ route('menu.semaine') }}" :active="request()->routeIs('menu.semaine')">
                        🍽️ Menu Semaine
                    </x-nav-link>
                    <x-nav-link href="{{ route('reservations.index') }}" :active="request()->routeIs('reservations.*')">
                        📅 Mes Réservations
                    </x-nav-link>
                    @if(auth()->user()?->isAdmin())
                        <x-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.*')">
                            ⚙️ Administration
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Menu utilisateur desktop -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-600 bg-white hover:text-[#4a0d12] focus:outline-none transition">
                                    {{ Auth::user()->name }}
                                    @if(auth()->user()->isAdmin())
                                        <span class="ml-2 px-1.5 py-0.5 text-[9px] font-bold uppercase bg-[#f8b803] text-[#4a0d12] rounded">Admin</span>
                                    @endif
                                    <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400 font-semibold uppercase tracking-wider">
                                Mon compte
                            </div>
                            <x-dropdown-link href="{{ route('profile.show') }}">
                                👤 Mon profil
                            </x-dropdown-link>
                            <x-dropdown-link href="{{ route('reservations.index') }}">
                                📅 Mes réservations
                            </x-dropdown-link>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    🚪 Se déconnecter
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Bouton hamburger mobile -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu mobile déroulant -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                🏠 Accueil
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('menu.semaine') }}" :active="request()->routeIs('menu.semaine')">
                🍽️ Menu Semaine
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('reservations.index') }}" :active="request()->routeIs('reservations.*')">
                📅 Mes Réservations
            </x-responsive-nav-link>
            @if(auth()->user()?->isAdmin())
                <x-responsive-nav-link href="{{ route('admin.users.index') }}" :active="request()->routeIs('admin.*')">
                    ⚙️ Administration
                </x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    👤 Mon profil
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        🚪 Se déconnecter
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
