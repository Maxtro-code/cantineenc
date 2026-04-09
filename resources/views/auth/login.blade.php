<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion - Restauration ENC Bessières</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --enc-red: #f53003; --enc-dark: #4a0d12; --enc-gold: #f8b803; }
        body { font-family: 'Instrument Sans', sans-serif; background: linear-gradient(135deg, #f9fafb 0%, #ffe4e1 100%); min-height: 100vh; }
        .glass-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .glass-dark { background: rgba(74, 13, 18, 0.95); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="flex items-center justify-center p-4 lg:p-6">
<div class="w-full max-w-5xl flex flex-col items-center">
    <div class="mb-10 text-center">
        <div class="flex items-center justify-center gap-2">
            <span class="text-[--enc-gold] font-black text-4xl lg:text-5xl italic tracking-tighter">ENC</span>
            <span class="text-[--enc-red] font-black text-4xl lg:text-5xl uppercase tracking-tighter">Bessières</span>
        </div>
        <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-[--enc-dark] mt-2 opacity-60">Portail de Restauration Scolaire</p>
    </div>

    <main class="w-full flex flex-col lg:flex-row shadow-2xl rounded-[3rem] overflow-hidden glass-card">
        <div class="flex-1 p-8 lg:p-14">
            <div class="mb-8">
                <h2 class="text-3xl font-bold tracking-tight text-[--enc-dark]">Espace Restauration</h2>
                <div class="h-1.5 w-12 bg-[--enc-gold] mt-4 rounded-full"></div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Adresse Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-white border border-gray-100 rounded-2xl px-5 py-3.5 outline-none focus:ring-2 focus:ring-[--enc-red] transition-all text-sm">
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-400">Mot de passe</label>
                        <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-[--enc-red] uppercase tracking-widest hover:underline">Oublié ?</a>
                    </div>
                    <input type="password" name="password" required class="w-full bg-white border border-gray-100 rounded-2xl px-5 py-3.5 outline-none focus:ring-2 focus:ring-[--enc-red] transition-all">
                </div>
                <button type="submit" class="w-full bg-[--enc-dark] text-white py-4 rounded-xl font-bold uppercase tracking-[0.2em] text-xs shadow-lg hover:bg-black transition-all">Se connecter</button>
            </form>
            <div class="mt-8 text-center text-xs text-gray-400">
                Pas de compte ? Contactez <a href="mailto:restauration@enc-bessieres.org" class="text-[--enc-red] font-bold hover:underline">restauration@enc-bessieres.org</a>
            </div>
        </div>
        <div class="lg:w-[350px] glass-dark p-12 text-white flex flex-col justify-between hidden lg:flex">
            <div><div class="w-10 h-1 bg-[--enc-gold] mb-10 rounded-full"></div><h3 class="text-2xl font-bold mb-8 italic italic">Mangez bien, réussissez mieux.</h3></div>
            <div class="pt-8 border-t border-white/10 text-[9px] uppercase tracking-widest text-gray-500 font-bold text-left">ENC Bessières Paris - 17e</div>
        </div>
    </main>
    <footer class="mt-12 text-[10px] text-gray-400 font-bold uppercase tracking-[0.5em]">&copy; 2026 ECOLE NATIONALE DE COMMERCE BESSIÈRES</footer>
</div>
</body>
</html>
