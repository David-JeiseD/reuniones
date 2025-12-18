<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPerfilCompleto
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            // Si es admin, lo dejamos pasar siempre (opcional)
            if (auth()->user()->hasRole('admin')) {
                return $next($request);
            }

            // Para el resto, validar perfil_completo
            if (!auth()->user()->perfil_completo && !$request->is('completar-perfil*')) {
                return redirect()->route('perfil.completar');
            }
        }
        return $next($request);
    }
}
