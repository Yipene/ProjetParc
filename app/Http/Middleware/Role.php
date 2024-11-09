<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Vérifie si l'utilisateur est authentifié
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthorized: Please veuillez vous connecter pour cette opération.'], 401);
        }

        // Vérifie si l'utilisateur a le rôle requis
        if ($request->user()->role !== $role) {
            return response()->json(['message' => "Forbidden: Vous n'avez pas le rôle nécessaire pour cette action."], 403);
        }

        return $next($request);
    }
}
