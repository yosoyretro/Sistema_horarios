<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AutenticacionSistema
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        
        if (!$token) {
            return response()->json([
                "error" => "Falta el token",
                "message" => "Se requiere un token para acceder a esta ruta."
            ], 401);
        }
                
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                "error" => "Token no válido",
                "message" => "El token proporcionado no es válido o esta expirado."
            ], 401);
        }


        return $next($request);
    }
}
