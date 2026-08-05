<?php

namespace App\Support;

class UserAgentParser
{
    /**
     * Turns a raw User-Agent string into a short "Browser on OS" label for
     * the active-sessions list. Not trying to be a full device-detection
     * library — just enough for a human to recognize which device this is.
     */
    public static function describe(?string $userAgent): string
    {
        if (! $userAgent) {
            return 'Unknown device';
        }

        $os = match (true) {
            str_contains($userAgent, 'Windows') => 'Windows',
            str_contains($userAgent, 'Android') => 'Android',
            (bool) preg_match('/iPhone|iPad|iOS/', $userAgent) => 'iOS',
            str_contains($userAgent, 'Mac OS X') => 'macOS',
            str_contains($userAgent, 'Linux') => 'Linux',
            default => null,
        };

        $browser = match (true) {
            str_contains($userAgent, 'Edg/') => 'Edge',
            str_contains($userAgent, 'OPR/') => 'Opera',
            str_contains($userAgent, 'Chrome/') => 'Chrome',
            str_contains($userAgent, 'CriOS/') => 'Chrome',
            str_contains($userAgent, 'Firefox/') => 'Firefox',
            str_contains($userAgent, 'Safari/') && str_contains($userAgent, 'Version/') => 'Safari',
            default => null,
        };

        return match (true) {
            $browser && $os => "{$browser} on {$os}",
            $browser => $browser,
            $os => $os,
            default => 'Unknown device',
        };
    }
}
