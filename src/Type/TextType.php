<?php

declare(strict_types=1);

namespace Expando\Translator\Type;

class TextType
{
    const
        PRODUCT_TITLE = 'product_title',
        PRODUCT_DESCRIPTION = 'product_description',
        PRODUCT_PARAMETER = 'product_parameter',
        PRODUCT_CATEGORY = 'category',
        TAG = 'tag',
        OTHER = 'other';

    public static function getAll(): array
    {
        return [
            self::PRODUCT_TITLE,
            self::PRODUCT_DESCRIPTION,
            self::PRODUCT_PARAMETER,
            self::PRODUCT_CATEGORY,
            self::TAG,
            self::OTHER,
        ];
    }
}
