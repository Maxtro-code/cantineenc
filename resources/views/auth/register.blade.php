<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="5;url={{ route('login') }}">
    <title>Inscription désactivée - ENC Bessières</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root { --enc-red: #f53003; --enc-dark: #4a0d12; --enc-gold: #f8b803; }
        body { font-family: sans-serif; background: linear-gradient(135deg, #f9fafb 0%, #ffe4e1 100%); min-height: 100vh; }
    </style>
</head>
<body class="flex items-center justify-center p-6">
<div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-10 text-center">
    <div class="flex items-baseline justify-center gap-2 mb-6">
        <span class="text-[--enc-gold] font-black text-3xl italic">ENC</span>
        <span class="text-[--enc-red] font-black text-3xl uppercase">Bessières</span>
    </div>
    <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
        <span class="text-2xl">🔒</span>
    </div>
    <h2 class="text-xl font-bold text-[--enc-dark] mb-3">Inscription désactivée</h2>
    <p class="text-sm text-gray-500 mb-6">
        L'inscription en ligne n'est pas disponible.<br>
        Pour créer un compte, contactez l'administration de la cantine.
    </p>
    <a href="mailto:restauration@enc-bessieres.org"
       class="block mb-4 text-sm font-semibold text-[--enc-red] hover:underline">
        restauration@enc-bessieres.org
    </a>
    <p class="text-xs text-gray-400 mb-6">Redirection automatique dans 5 secondes…</p>
    <a href="{{ route('login') }}"
       class="inline-block px-6 py-3 bg-[--enc-dark] text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-black transition">
        Retour à la connexion
    </a>
</div>
</body>
</html>
