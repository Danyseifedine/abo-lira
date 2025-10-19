<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'hint',
        'group',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get a setting value by key
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting.{$key}", now()->addDay(), function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting?->value ?? $default;
        });
    }

    /**
     * Set a setting value by key
     */
    public static function set(string $key, mixed $value, ?string $group = null, ?string $hint = null): self
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group ?? 'general',
                'hint' => $hint,
            ]
        );

        Cache::forget("setting.{$key}");
        Cache::forget('settings.all');
        Cache::forget("settings.group.{$setting->group}");

        return $setting;
    }

    /**
     * Get all settings grouped by category
     */
    public static function getAllGrouped(): array
    {
        return Cache::remember('settings.all', now()->addDay(), function () {
            return static::all()
                ->groupBy('group')
                ->map(function ($settings) {
                    return $settings->map(function ($setting) {
                        return [
                            'id' => $setting->id,
                            'key' => $setting->key,
                            'value' => $setting->value,
                            'hint' => $setting->hint,
                        ];
                    });
                })
                ->toArray();
        });
    }

    /**
     * Get all settings grouped by category (safe for frontend)
     * Excludes sensitive settings like passwords, API keys, etc.
     */
    public static function getAllGroupedForFrontend(): array
    {
        // List of sensitive keys that should never be exposed to frontend
        $sensitiveKeys = [
            'mail_password',
            'mail_username',
            'aws_secret_key',
            'stripe_secret',
            'api_key',
            'api_secret',
            'private_key',
            'secret_key',
        ];

        return Cache::remember('settings.all.frontend', now()->addDay(), function () use ($sensitiveKeys) {
            return static::all()
                ->reject(function ($setting) use ($sensitiveKeys) {
                    // Reject any setting whose key contains sensitive keywords
                    foreach ($sensitiveKeys as $sensitiveKey) {
                        if (str_contains(strtolower($setting->key), strtolower($sensitiveKey))) {
                            return true;
                        }
                    }

                    return false;
                })
                ->groupBy('group')
                ->map(function ($settings) {
                    return $settings->map(function ($setting) {
                        return [
                            'id' => $setting->id,
                            'key' => $setting->key,
                            'value' => $setting->value,
                            'hint' => $setting->hint,
                        ];
                    })->values();
                })
                ->toArray();
        });
    }

    /**
     * Get settings by group
     */
    public static function getByGroup(string $group): array
    {
        return Cache::remember("settings.group.{$group}", now()->addDay(), function () use ($group) {
            return static::where('group', $group)
                ->get()
                ->mapWithKeys(fn($setting) => [$setting->key => $setting->value])
                ->toArray();
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        // Clear all settings-related cache keys
        Cache::forget('settings.all');
        Cache::forget('settings.all.frontend');

        // Clear individual setting caches
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget("settings.group.{$setting->group}");
        }
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function booted(): void
    {
        static::saved(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget('settings.all');
            Cache::forget('settings.all.frontend');
            Cache::forget("settings.group.{$setting->group}");
        });

        static::deleted(function ($setting) {
            Cache::forget("setting.{$setting->key}");
            Cache::forget('settings.all');
            Cache::forget('settings.all.frontend');
            Cache::forget("settings.group.{$setting->group}");
        });
    }
}
