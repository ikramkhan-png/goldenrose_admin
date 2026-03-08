<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect authenticated users to the appropriate dashboard
                $user = Auth::guard($guard)->user();
                
                // Check user roles using Spatie
                try {
                    if ($user->hasRole('admin') || $user->hasRole('super_admin')) {
                        return redirect()->route('admin.dashboard');
                    } elseif ($user->hasRole('client')) {
                        return redirect()->route('client.dashboard');
                    }
                } catch (\Exception $e) {
                    // If roles check fails, use type field as fallback
                    if (in_array($user->type, ['admin', 'super_admin'])) {
                        return redirect()->route('admin.dashboard');
                    } elseif ($user->type === 'client') {
                        return redirect()->route('client.dashboard');
                    }
                }
                
                // Final fallback to admin dashboard (for authenticated users without proper roles)
                return redirect()->route('admin.dashboard');
            }
        }

        // User is NOT authenticated - allow them to proceed to login/register pages
        return $next($request);
    }
}
