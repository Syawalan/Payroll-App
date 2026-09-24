<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        // Izinkan jika role user sesuai dengan role yang diminta di route.
        // Jika route meminta 'admin' sedangkan di DB 'owner', kita samakan hak aksesnya.
        if (in_array($userRole, $roles) || ($userRole === 'owner' && in_array('admin', $roles))) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}