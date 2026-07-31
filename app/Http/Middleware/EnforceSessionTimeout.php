<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceSessionTimeout
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('auth_user_id')) {
            return $next($request);
        }

        $lastActivity = (int) $request->session()->get('last_activity', 0);
        $timeoutInSeconds = config('session.lifetime') * 60;

        if ($lastActivity !== 0 && (time() - $lastActivity) > $timeoutInSeconds) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'Your session timed out. Please log in again.');
        }

        $request->session()->put('last_activity', time());

        return $next($request);
    }
}
