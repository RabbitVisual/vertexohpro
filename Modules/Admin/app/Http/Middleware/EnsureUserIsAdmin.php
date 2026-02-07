<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Simple check: In a real app, use Spatie Roles ->hasRole('admin')
        // For now, we'll check a specific email or property if role logic isn't fully seeded yet
        if (!$request->user() || !$request->user()->hasRole('admin')) {
             // Fallback for development/testing if role not assigned
             if ($request->user() && $request->user()->email !== 'admin@vertex.com') {
                 abort(403, 'Acesso não autorizado.');
             }
        }

        return $next($request);
    }
}
