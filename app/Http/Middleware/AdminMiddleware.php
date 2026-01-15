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
        // untuk laravel 12 middleware refrensinya : https://laravel.com/docs/12.x/middleware
        // 0 admin, 1 user biasa (akan di batasin yang 1 saja)
        if (Auth::check() && Auth::user()->role === 1) abort(401);
        return $next($request);
    }
}
