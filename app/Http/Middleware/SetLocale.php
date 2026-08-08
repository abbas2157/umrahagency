<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const SUPPORTED = ['en', 'ur'];

    /**
     * Logged-in users carry their language on their account (it's an admin
     * tool preference, not a public URL — no SEO reason to put it in the
     * URL, and it should follow them to any device they log in on).
     * Guests (the login screen) get a session-only choice instead.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->user()?->locale ?? session('locale');

        if (! in_array($locale, self::SUPPORTED, true)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
