<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user exist
        if (!is_null(Auth::user())) {
            // Redirect admin to dashboard
            if (Auth::user()->is_admin) {
                return redirect('/dashboard');
            }
        }
        else {
            return redirect('/login');
        }

        return $next($request);
    }
}
