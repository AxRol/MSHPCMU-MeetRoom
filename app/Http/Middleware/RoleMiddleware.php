<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Vérifie si l'utilisateur est authentifié
        if (!Auth::check()) {
            Log::error('Utilisateur non authentifié.');
            return redirect()->route('login'); // Redirige vers la page de connexion
        }

        // Récupère l'utilisateur authentifié
        $user = Auth::user();
        Log::info('Utilisateur authentifié:', ['user' => $user, 'roles' => $user->roles->pluck('name')->toArray()]);

        // Vérifie si l'utilisateur a l'un des rôles requis
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                Log::info('Rôle trouvé:', ['role' => $role]);
                return $next($request); // Autorise l'accès
            }
        }

        // Si aucun rôle ne correspond, accès refusé
        Log::error('Aucun rôle correspondant:', ['roles' => $roles]);
       // abort(403, 'Accès non autorisé.'); // Renvoie une erreur 403
      return redirect()->route('403');
    }
}
