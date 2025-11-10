<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return redirect('/dashboard');
            }
        }

        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}

