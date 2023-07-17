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
        if (Auth::user() !== null) {
            // Redirect admin to dashboard page
            if (Auth::user()->is_admin) {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
