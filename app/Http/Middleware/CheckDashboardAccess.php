<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDashboardAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Seuls admin et agent peuvent accéder au dashboard
        if (!in_array($user->role, ['admin', 'agent'])) {
            abort(403, 'Accès refusé. Seuls les agents et administrateurs peuvent accéder au dashboard.');
        }

        return $next($request);
    }
}