<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if user is authenticated
        if (!$user) {
            return redirect('/login');
        }

        // Check if user is a client (type = 'client')
        if ($user->type !== 'client') {
            abort(403, 'Unauthorized access. This dashboard is for clients only.');
        }

        // Check if user has a client_type (service or project)
        if (!$user->client_type || !in_array($user->client_type, ['service', 'project'])) {
            abort(403, 'Invalid client type.');
        }

        return $next($request);
    }
}
