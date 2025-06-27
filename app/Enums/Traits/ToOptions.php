<?php

namespace App\Enums\Traits;

trait ToOptions
{
    private static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    private static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_combine(self::values(), self::names());
    }
}
