<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next, $permission): Response
    // {
    //     if (!Auth::check() || !Auth::user()->can($permission)) {
    //         abort(403, 'Accès refusé.');
    //     }

    //     return $next($request);
    // }
     public function handle(Request $request, Closure $next, $permission)
    {
        if (!Auth::check() || !Auth::user()->can($permission)) {
           // $j =  Auth::user()->can($permission);
            abort(403, 'AAAAAAccès refusé.');
        }

        return $next($request);
    }
}
