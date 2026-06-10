<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Check if user has the required role(s).
     *
     * Usage in routes:
     * Route::middleware(['role:admin'])->group(...)        // Only admin
     * Route::middleware(['role:admin,manager'])->group(...) // Admin OR Manager
     *
     * MERN equivalent:
     * app.get('/admin', authMiddleware, (req, res, next) => {
     *     if (!['admin'].includes(req.user.role)) return res.status(403);
     *     next();
     * });
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if (auth()->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // If no matching role found — 403 Forbidden
        abort(403, 'Unauthorized. You do not have the required role to access this page.');
    }
}
