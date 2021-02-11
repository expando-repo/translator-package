<?php

declare(strict_types=1);

namespace Expando\Translator\Type;

class SkipTextTag
{
    const
        TAG_BRAND = 'brand',
        TAG_BAND = 'band'
    ;

    public static function getAll(): array
    {
        return [
            self::TAG_BRAND,
            self::TAG_BAND,
        ];
    }
}
