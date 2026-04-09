<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Autorise uniquement les administrateurs.
     * Redirige vers le dashboard si l'utilisateur n'est pas admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}
