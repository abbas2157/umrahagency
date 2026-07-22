<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap.xml, combining the static top-level routes with
     * every package view found under resources/views/umrah and /hajj,
     * so newly added package pages are picked up automatically.
     */
    public function index()
    {
        $baseUrl = 'https://umrahagency.pk';

        $staticUrls = [
            ['loc' => '/', 'priority' => '1.0'],
            ['loc' => '/about-us.html', 'priority' => '0.7'],
            ['loc' => '/contact-us.html', 'priority' => '0.7'],
            ['loc' => '/reviews.html', 'priority' => '0.6'],
            ['loc' => '/terms-conditions.html', 'priority' => '0.3'],
            ['loc' => '/privacy-policy.html', 'priority' => '0.3'],
            ['loc' => '/payment-security.html', 'priority' => '0.3'],
            ['loc' => '/cookies-policy.html', 'priority' => '0.3'],
            ['loc' => '/hajj-packages.html', 'priority' => '0.9'],
            ['loc' => '/umrah-visa.html', 'priority' => '0.8'],
            ['loc' => '/umrah-packages.html', 'priority' => '0.9'],
            ['loc' => '/umrah-packages-2026.html', 'priority' => '0.9'],
            ['loc' => '/december-umrah-packages.html', 'priority' => '0.8'],
            ['loc' => '/umrah-in-ramadan.html', 'priority' => '0.8'],
            ['loc' => '/easter-umrah-packages.html', 'priority' => '0.8'],
            ['loc' => '/lahore-umrah-packages.html', 'priority' => '0.8'],
        ];

        $urls = array_map(fn ($u) => [
            'loc' => $baseUrl . $u['loc'],
            'priority' => $u['priority'],
        ], $staticUrls);

        foreach ($this->packageSlugs('umrah') as $slug) {
            $urls[] = [
                'loc' => "{$baseUrl}/umrah/{$slug}.html",
                'priority' => '0.8',
            ];
        }

        foreach ($this->packageSlugs('hajj') as $slug) {
            $urls[] = [
                'loc' => "{$baseUrl}/hajj/{$slug}.html",
                'priority' => '0.8',
            ];
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }

    /**
     * @return array<int, string>
     */
    private function packageSlugs(string $directory): array
    {
        $path = resource_path("views/{$directory}");

        if (! File::isDirectory($path)) {
            return [];
        }

        return collect(File::files($path))
            ->filter(fn ($file) => $file->getExtension() === 'php')
            ->map(fn ($file) => str_replace('.blade.php', '', $file->getFilename()))
            ->values()
            ->all();
    }
}
