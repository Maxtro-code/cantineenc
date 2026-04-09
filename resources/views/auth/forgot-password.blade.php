<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Récupération - Restauration ENC Bessières</title>

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
            background: linear-gradient(135deg, #f9fafb 0%, #ffe4e1 50%, #f3f4f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .glass-dark {
            background: rgba(74, 13, 18, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

<div class="w-full max-w-5xl flex flex-col items-center">

    <div class="mb-10 text-center">
        <div class="flex items-center justify-center gap-2">
            <span class="text-[--enc-gold] font-black text-4xl lg:text-5xl italic tracking-tighter">ENC</span>
            <span class="text-[--enc-red] font-black text-4xl lg:text-5xl uppercase tracking-tighter">Bessières</span>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-[--enc-dark] mt-2 opacity-60">
            Portail de Restauration Scolaire
        </p>
    </div>

    <main class="w-full flex flex-col lg:flex-row shadow-2xl rounded-[3rem] overflow-hidden glass-card">

        <div class="flex-1 p-8 lg:p-14 text-left">
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-[--enc-dark]">Mot de passe oublié</h2>
                <div class="h-1.5 w-12 bg-[--enc-gold] mt-4 rounded-full"></div>
            </div>

            <div class="mb-8 text-sm text-gray-500 leading-relaxed italic">
                Aucun problème. Indiquez-nous votre adresse e-mail académique et nous vous enverrons un lien de réinitialisation.
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-xs font-bold rounded-r-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Email Académique</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-white border border-gray-100 rounded-2xl px-5 py-3.5 outline-none focus:ring-2 focus:ring-[--enc-red] transition-all text-sm shadow-sm">
                    @error('email')
                    <p class="text-red-500 text-[10px] mt-2 font-bold uppercase tracking-wider">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-[--enc-dark] text-white py-4 rounded-xl font-bold uppercase tracking-[0.2em] text-xs shadow-lg hover:bg-black transition-all">
                    Envoyer le lien de secours
                </button>
            </form>

            <div class="mt-8 text-center text-xs text-gray-400">
                <a href="{{ route('login') }}" class="hover:text-[--enc-red] transition-colors">
                    Retour à la <span class="font-bold border-b border-[--enc-red]">connexion</span>
                </a>
            </div>
        </div>

        <div class="lg:w-[380px] glass-dark p-12 lg:p-14 text-white flex flex-col justify-between hidden lg:flex border-l border-white/5">
            <div class="relative z-10 text-left">
                <div class="w-10 h-1 bg-[--enc-gold] mb-10 rounded-full"></div>
                <h3 class="text-2xl font-bold mb-8 italic leading-tight">
                    Sécurisez votre <span class="text-[--enc-gold]">accès</span>.
                </h3>
                <p class="text-xs text-gray-300 leading-relaxed">
                    Pour des raisons de sécurité, utilisez uniquement votre adresse officielle terminée par <span class="text-[--enc-gold]">@enc-bessieres.org</span>.
                </p>
            </div>

            <div class="pt-8 border-t border-white/10 text-[9px] uppercase tracking-[0.3em] text-gray-500 font-bold text-left">
                ENC Bessières Paris - 17e
            </div>
        </div>
    </main>

    <footer class="mt-12 text-[10px] text-gray-400 font-bold uppercase tracking-[0.5em]">
        &copy; {{ date('Y') }} ECOLE NATIONALE DE COMMERCE BESSIÈRES
    </footer>
</div>

</body>
</html>
