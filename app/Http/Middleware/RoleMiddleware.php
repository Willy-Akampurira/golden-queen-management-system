<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; // ✅ Use Symfony's base Response

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage:
     * Route::middleware([RoleMiddleware::class . ':admin'])...
     * Route::middleware([RoleMiddleware::class . ':admin,worker'])...
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // ✅ Return abort() response correctly
        if (! $user || ! in_array($user->role, $roles)) {
            return abort(403, 'Unauthorized: Access denied.');
        }

        return $next($request);
    }
}
