<?php

namespace App\Navigation;

class SuperAdminPath
{
    private const PREFIX = 'dashboard/super-admin';

    public static function view(string $path): string
    {
        return self::PREFIX . '/' . $path;
    }
}
