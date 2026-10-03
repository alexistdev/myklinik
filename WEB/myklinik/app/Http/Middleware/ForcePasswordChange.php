<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->must_change_password && !$request->routeIs('password.force', 'password.force.update', 'logout')) {
            if ($request->expectsJson()) {
                abort(403, 'Anda harus mengganti password terlebih dahulu.');
            }
            return redirect()->route('password.force');
        }

        return $next($request);
    }
}
