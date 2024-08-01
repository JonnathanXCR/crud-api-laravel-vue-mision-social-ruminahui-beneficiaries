<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRole = Auth::user()->has_role;
            
        var_dump($userRole);

        // Verificar si el rol del usuario está dentro de los roles permitidos
        if (!in_array($userRole, $roles)) {
                
            // Si el usuario no tiene el rol permitido, devolver una respuesta de no autorizado
            return response()->json(['message' => 'No está autorizado'], 403);
        }



        // Si el usuario tiene el rol permitido, continuar con la solicitud
        return $next($request);
    }
}