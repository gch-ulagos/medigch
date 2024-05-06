<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasRole('medic')) {
            return $next($request);
        }

        return redirect()->route('dashboard'); // Puedes definir la ruta 'unauthorized' en tu archivo de rutas.
    }
}
