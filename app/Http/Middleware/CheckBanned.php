<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isBanned()) {
            $allowedRoutes = [
                'public.ban.show',
                'public.ban.appeal',
                'public.logout',
            ];

            if (!$request->routeIs($allowedRoutes)) {
                return redirect()->route('public.ban.show');
            }
        }

        return $next($request);
    }
}
