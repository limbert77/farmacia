<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->rol === 'admin' || auth()->user()->rol === 'farmacéutico')) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado.');
    }
}
