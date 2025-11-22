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
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Verificar que sea el administrador
        if (Auth::user()->email !== 'admin@erp.local') {
            return redirect('/dashboard')->with('error', 'No tienes permisos para gestionar usuarios.');
        }

        return $next($request);
    }
}
