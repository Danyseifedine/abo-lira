<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $user = $request->user();

        if (config('app.features.multi_lang')) {
            $translations = $this->getTranslations(app()->getLocale());
        } else {
            $translations = [];
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'locale' => app()->getLocale(),
            'translations' => $translations,
            'auth' => [
                'user' => $user,
                'is_authenticated' => $user ? true : false,
                'permissions' => $user?->getAllPermissions()->pluck('name') ?? collect(),
                'roles' => $user?->getRoleNames() ?? collect(),
            ],
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'flash' => [
                'toast' => $request->session()->get('toast'),
            ],
        ];
    }

    /**
     * Get translations for the given locale (only commonly used ones for performance).
     */
    private function getTranslations(string $locale): array
    {
        $translations = [];

        // Load JSON translations
        $jsonPath = lang_path("{$locale}.json");
        if (file_exists($jsonPath)) {
            $jsonTranslations = json_decode(file_get_contents($jsonPath), true);
            if ($jsonTranslations) {
                $translations = array_merge($translations, $jsonTranslations);
            }
        }

        // Load only essential PHP translation files for performance
        $essentialFiles = ['auth', 'validation', 'passwords', 'sidebar', 'datatable', 'order'];

        foreach ($essentialFiles as $file) {
            $filePath = lang_path("{$locale}/{$file}.php");
            if (file_exists($filePath)) {
                $fileTranslations = require $filePath;
                if (is_array($fileTranslations)) {
                    foreach ($fileTranslations as $key => $value) {
                        $fullKey = "{$file}.{$key}";
                        if (is_array($value)) {
                            // Flatten nested arrays
                            foreach ($value as $nestedKey => $nestedValue) {
                                $translations["{$fullKey}.{$nestedKey}"] = $nestedValue;
                            }
                        } else {
                            $translations[$fullKey] = $value;
                        }
                    }
                }
            }
        }

        return $translations;
    }
}
