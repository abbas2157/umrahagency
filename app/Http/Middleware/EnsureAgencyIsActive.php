<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgencyIsActive
{
    /**
     * Bounce an already-logged-in session the moment its agency is
     * deactivated, so a suspension takes effect immediately rather than
     * waiting for the user's next login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->isSuperAdmin() && $user->agency && ! $user->agency->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your agency has been deactivated. Contact the platform administrator.',
            ]);
        }

        if ($user && ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Your account has been deactivated. Contact your agency admin.',
            ]);
        }

        return $next($request);
    }
}
