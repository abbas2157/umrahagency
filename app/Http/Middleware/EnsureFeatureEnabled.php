<?php

namespace App\Http\Middleware;

use App\Support\Feature;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFeatureEnabled
{
    /**
     * Blocks a route group behind a Feature key — see App\Support\Feature
     * for the registry. Super Admin is never gated: they need to reach an
     * agency's screens regardless of that agency's toggles.
     */
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        $user = $request->user();

        if ($user && ! $user->isSuperAdmin() && ! $user->agency?->hasFeature($featureKey)) {
            return response()->view('errors.feature-disabled', [
                'featureLabel' => Feature::label($featureKey),
            ], 403);
        }

        return $next($request);
    }
}
