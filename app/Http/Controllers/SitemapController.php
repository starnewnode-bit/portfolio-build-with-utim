<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $base = rtrim(config('app.url') ?: url('/'), '/');

        $urls = [];

        // Static pages
        $urls[] = ['loc' => route('home'),            'priority' => '1.0', 'changefreq' => 'weekly'];
        $urls[] = ['loc' => route('about'),           'priority' => '0.8', 'changefreq' => 'monthly'];
        $urls[] = ['loc' => route('projects.index'),  'priority' => '0.9', 'changefreq' => 'weekly'];
        $urls[] = ['loc' => route('contact'),         'priority' => '0.6', 'changefreq' => 'yearly'];

        // Project pages
        Project::where('is_published', true)
            ->orderByDesc('published_at')
            ->get(['slug', 'updated_at', 'published_at'])
            ->each(function (Project $p) use (&$urls, $base) {
                $urls[] = [
                    'loc'        => route('projects.show', $p->slug),
                    'lastmod'    => optional($p->updated_at ?? $p->published_at)->toAtomString(),
                    'priority'   => '0.7',
                    'changefreq' => 'monthly',
                ];
            });

        $xml = view('sitemap.xml', ['urls' => $urls])->render();

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }
}
