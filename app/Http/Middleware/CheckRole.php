<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    /* public function handle(Request $request, Closure $next, $role): Response
    {
       // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Vérifie si l'utilisateur a le rôle requis
        if (!Auth::user()->hasRole($role)) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
    } */

   public function handle(Request $request, Closure $next, $role)
{
    if (!Auth::check()) {
            return redirect('/login');
        }

        // Vérifie si l'utilisateur a le rôle requis
        if (!Auth::user()->hasRole($role)) {
            abort(403, 'Accès refusé.');
        }

        return $next($request);
}

}
