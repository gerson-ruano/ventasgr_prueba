<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->status !== 'Active') { // Verifica que el estado sea 'Active'
            Auth::logout(); // Cierra la sesión del usuario
            return redirect()->route('login')->with('error', 'Tu cuenta está deshabilitada. Contacta al administrador.');
        }
        return $next($request);
    }
}
