<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Vérifiez si l'utilisateur est connecté et s'il est administrateur
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // Redirigez vers la page d'accueil ou une autre page si l'utilisateur n'est pas admin
        return redirect('/')->with('error', 'Vous n\'avez pas accès à cette section.');
    }
}
