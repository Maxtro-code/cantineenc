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
            /* Dégradé de fond inspiré de l'ENC */
            background: linear-gradient(135deg, #f9fafb 0%, #ffe4e1 50%, #f3f4f6 100%);
            overflow-x: hidden;
        }

        /* Effet de verre transparent (Glassmorphism) */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-dark {
            background: rgba(74, 13, 18, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Animation du fond */
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
<body class="flex items-center justify-center min-h-screen p-4 relative">

<div class="bg-blob top-[-100px] left-[-100px]"></div>
<div class="bg-blob bottom-[-100px] right-[-100px]"></div>

<div class="w-full max-w-5xl flex flex-col items-center">

    <div class="mb-10 text-center scale-90 lg:scale-100">
        <div class="flex items-baseline gap-2">
            <span class="text-[--enc-gold] font-black text-5xl italic tracking-tighter drop-shadow-sm">ENC</span>
            <span class="text-[--enc-red] font-black text-5xl uppercase tracking-tighter drop-shadow-sm">Bessières</span>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-[0.5em] text-[--enc-dark] mt-3 opacity-70">
            École Nationale de Commerce Paris
        </p>
    </div>

    <main class="w-full flex flex-col lg:flex-row shadow-[0_32px_64px_-16px_rgba(74,13,18,0.2)] rounded-[3rem] overflow-hidden glass-card">

        <div class="flex-1 p-10 lg:p-16">
            <div class="mb-10">
                <h2 class="text-3xl font-bold tracking-tight text-[--enc-dark]">Espace Restauration</h2>
                <div class="h-1.5 w-16 bg-[--enc-red] mt-4 rounded-full"></div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2 ml-1">Identifiant Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="prenom.nom@enc-bessieres.org"
                           class="w-full bg-white/50 border border-white rounded-2xl px-6 py-4 outline-none focus:ring-2 focus:ring-[--enc-red] focus:bg-white transition-all shadow-sm">
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500">Mot de passe</label>
                        <a href="#" class="text-[10px] font-bold text-[--enc-red] uppercase tracking-widest hover:text-[--enc-dark]">Oublié ?</a>
                    </div>
                    <input type="password" name="password" required
                           class="w-full bg-white/50 border border-white rounded-2xl px-6 py-4 outline-none focus:ring-2 focus:ring-[--enc-red] focus:bg-white transition-all shadow-sm">
                </div>

                <button type="submit" class="w-full bg-[--enc-dark] text-white py-5 rounded-2xl font-bold uppercase tracking-[0.2em] text-xs shadow-xl hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all mt-4">
                    Se connecter
                </button>
            </form>
        </div>

    </main>

    <footer class="mt-12 text-[10px] text-gray-500 font-bold uppercase tracking-[0.5em]">
        &copy; {{ date('Y') }} ENC BESSIÈRES - SERVICE NUMÉRIQUE
    </footer>
</div>

</body>
</html>
