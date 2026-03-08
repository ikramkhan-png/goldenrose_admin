<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has admin or super_admin role
        if (method_exists($user, 'hasRole')) {
            // Using Spatie Laravel Permission
            if (!$user->hasRole(['admin', 'super_admin'])) {
                abort(403, 'Unauthorized. Only administrators can access this area.');
            }
        } else {
            // Fallback: check type field
            if (!in_array($user->type, ['admin', 'super_admin'])) {
                abort(403, 'Unauthorized. Only administrators can access this area.');
            }
        }

        return $next($request);
    }
}
