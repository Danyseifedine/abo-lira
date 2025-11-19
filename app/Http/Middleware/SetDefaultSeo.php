<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDefaultSeo
{
    /**
     * Handle an incoming request.
     *
     * Set default SEO data based on the current route.
     * Controllers can override these defaults using SEO helper functions.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = app()->getLocale();
        $routeName = $request->route()?->getName();
        $defaults = config('seo.defaults', []);

        // Set default SEO data from config
        $defaultTitle = $defaults['title'][$locale] ?? $defaults['title']['en'] ?? 'Abo Lira';
        $defaultDescription = $defaults['description'][$locale] ?? $defaults['description']['en'] ?? '';
        $defaultKeywords = $defaults['keywords'][$locale] ?? $defaults['keywords']['en'] ?? '';
        $defaultImage = $defaults['image'] ?? asset('logos/logo.png');

        // Set route-specific defaults (can be overridden in controllers)
        if ($routeName) {
            seo_data([
                'title' => $defaultTitle,
                'description' => $defaultDescription,
                'keywords' => $defaultKeywords,
                'image' => $defaultImage,
                'type' => 'website',
            ]);

            // Add breadcrumb for home
            if ($routeName !== 'home') {
                $homeTitle = $locale === 'ar' ? 'الرئيسية' : 'Home';
                seo_breadcrumb($homeTitle, route('home'));
            }
        }

        return $next($request);
    }
}
