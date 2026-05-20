<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class CheckRoleMod
{
    public function handle(Request $request, Closure $next): Response
    {
        // Auth::check() usa el guard por defecto (web), consistente con el middleware 'auth'
        if (!Auth::check()) {
            return response()->json(['message' => 'No autenticat'], 401);
        }

        if (!Auth::user()->isMod() && !Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Accés denegat: permisos insuficients, eres mod'], 403);
        }
                 
        return $next($request);
    }
}
