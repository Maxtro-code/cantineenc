<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Restauration ENC Bessières</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --enc-red: #f53003;
            --enc-dark: #4a0d12;
            --enc-gold: #f8b803;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            /* Arrière-plan dégradé */
            background: linear-gradient(135deg, #f9fafb 0%, #ffe4e1 50%, #f3f4f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Effet de verre transparent */
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Effet de verre sombre pour le côté droit */
        .glass-dark {
            background: rgba(74, 13, 18, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        /* Blobs décoratifs */
        .bg-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(245,48,3,0.1) 0%, rgba(248,184,3,0.05) 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>
<body>

<div class="bg-blob top-[-100px] left-[-100px]"></div>
<div class="bg-blob bottom-[-100px] right-[-100px]"></div>

<div class="w-full max-w-5xl flex flex-col items-center">

    <div class="mb-10 text-center">
        <div class="flex items-baseline justify-center gap-2">
            <span class="text-[--enc-gold] font-black text-4xl lg:text-5xl italic tracking-tighter drop-shadow-sm">ENC</span>
            <span class="text-[--enc-red] font-black text-4xl lg:text-5xl uppercase tracking-tighter drop-shadow-sm">Bessières</span>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[--enc-dark] mt-2 opacity-70">
            Portail de Restauration Scolaire
        </p>
    </div>

    <main class="w-full flex flex-col lg:flex-row shadow-[0_32px_64px_-16px_rgba(74,13,18,0.2)] rounded-[3rem] overflow-hidden glass-card">

        <div class="flex-1 p-8 lg:p-14">
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-[--enc-dark]">Espace Restauration</h2>
                <div class="h-1.5 w-12 bg-[--enc-gold] mt-4 rounded-full"></div>
            </div>

            @if (session('info'))
                <div class="mb-4 p-3 bg-blue-50 border-l-4 border-blue-500 text-blue-700 text-xs rounded-r-lg">
                    {{ session('info') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs rounded-r-lg">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2 ml-1">Adresse Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="prenom.nom@enc.fr"
                           class="w-full bg-white border border-gray-100 rounded-xl px-5 py-3.5 outline-none focus:ring-2 focus:ring-[--enc-red] transition-all shadow-sm text-sm">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500">Mot de passe</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-[--enc-red] uppercase tracking-widest hover:text-[--enc-dark]">Oublié ?</a>
                    </div>
                    <input id="password" type="password" name="password" required
                           class="w-full bg-white border border-gray-100 rounded-xl px-5 py-3.5 outline-none focus:ring-2 focus:ring-[--enc-red] transition-all shadow-sm">
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded accent-[#f53003]">
                    <label for="remember" class="text-sm text-gray-500 font-medium italic">Rester connecté</label>
                </div>

                <button type="submit" class="w-full bg-[--enc-dark] text-white py-4 rounded-xl font-bold uppercase tracking-[0.2em] text-xs shadow-lg hover:bg-black transition-all">
                    Se connecter
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-gray-400">
                Pas encore de compte ?
                <a href="mailto:restauration@enc-bessieres.org" class="text-[--enc-red] font-bold ml-1 hover:underline">
                    Contactez l'administration
                </a>
            </div>
        </div>

        <div class="lg:w-[350px] glass-dark p-10 text-white flex flex-col justify-between hidden lg:flex relative overflow-hidden border-l border-white/5">
            <div class="relative z-10">
                <div class="w-10 h-1 bg-[--enc-gold] mb-8 rounded-full"></div>
                <h3 class="text-xl font-bold mb-6 italic leading-relaxed">Mangez bien, réussissez mieux à l'ENC.</h3>

                <ul class="space-y-4">
                    <li class="flex items-center gap-3 text-xs text-gray-300">
                        <span class="text-[--enc-gold]">●</span> Consultation des menus hebdo
                    </li>
                    <li class="flex items-center gap-3 text-xs text-gray-300">
                        <span class="text-[--enc-gold]">●</span> Gestion simplifiée du badge
                    </li>
                </ul>
            </div>

            <div class="text-[9px] uppercase tracking-widest text-gray-500 font-bold">
                ENC Bessières Paris - 17e
            </div>
        </div>
    </main>

    <footer class="mt-10 text-[10px] text-gray-400 font-bold uppercase tracking-[0.5em]">
        &copy; 2026 Ecole Nationale de Commerce Bessières
    </footer>
</div>

</body>
</html>
