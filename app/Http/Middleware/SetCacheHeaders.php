<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCacheHeaders
{
    /**
     * Handle an incoming request.
     *
     * Set appropriate cache headers for static assets to improve performance.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only set cache headers for GET requests
        if (! $request->isMethod('GET')) {
            return $response;
        }

        // Note: This middleware only affects responses that go through Laravel.
        // Static assets (CSS, JS, images in public/) are served directly by the web server
        // and bypass Laravel middleware. Cache headers for static assets must be configured
        // at the server level (Apache .htaccess, Nginx config, etc.)

        $path = $request->path();
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        // Set cache headers for dynamic content and API responses
        if (in_array($extension, ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'woff', 'woff2', 'ttf', 'eot', 'ico'])) {
            // Cache for 1 year (31536000 seconds)
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
        } elseif (str_starts_with($path, 'assets/')) {
            // Cache other assets for 1 month
            $response->headers->set('Cache-Control', 'public, max-age=2592000');
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 2592000).' GMT');
        }

        // Enable compression
        $response->headers->set('Vary', 'Accept-Encoding');

        return $response;
    }
}
