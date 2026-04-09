<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accès refusé – ENC Bessières</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>:root { --enc-red: #f53003; --enc-dark: #4a0d12; --enc-gold: #f8b803; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-red-50 flex items-center justify-center p-6">
<div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-10 text-center">
    <div class="flex items-baseline justify-center gap-2 mb-8">
        <span class="text-[--enc-gold] font-black text-3xl italic">ENC</span>
        <span class="text-[--enc-red] font-black text-3xl uppercase">Bessières</span>
    </div>
    <p class="text-6xl font-black text-gray-100 mb-2">403</p>
    <h2 class="text-xl font-bold text-[--enc-dark] mb-3">Accès refusé</h2>
    <p class="text-sm text-gray-500 mb-8">
        Vous n'avez pas les droits nécessaires pour accéder à cette page.<br>
        Contactez un administrateur si vous pensez qu'il s'agit d'une erreur.
    </p>
    <div class="flex gap-3 justify-center">
        <a href="{{ url()->previous() }}"
           class="px-5 py-2.5 border border-gray-200 text-gray-600 text-xs font-bold uppercase rounded-xl hover:bg-gray-50 transition">
            ← Retour
        </a>
        <a href="{{ route('dashboard') }}"
           class="px-5 py-2.5 bg-[--enc-dark] text-white text-xs font-bold uppercase rounded-xl hover:bg-black transition">
            Accueil
        </a>
    </div>
</div>
</body>
</html>
