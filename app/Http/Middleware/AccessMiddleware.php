<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRole = auth()->user()->role;

        // Cek apakah user memiliki salah satu peran yang sesuai
        if (!in_array($userRole, $roles)) {
            return abort(403); // Forbidden
        }

        return $next($request);
    }
}
