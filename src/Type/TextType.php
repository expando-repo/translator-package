<?php

declare(strict_types=1);

namespace Expando\Translator\Type;

class TextType
{
    const
        PRODUCT_TITLE = 'product_title',
        PRODUCT_DESCRIPTION = 'product_description',
        PRODUCT_DESCRIPTION2 = 'product_description2',
        PRODUCT_DESCRIPTION_SHORT = 'product_description_short',
        PRODUCT_URL = 'product_url',
        PRODUCT_DIMENSION_TABLE = 'product_dimension_table',
        PRODUCT_PARAMETER = 'product_parameter',
        PRODUCT_CATEGORY = 'category',
        TAG = 'tag',
        OTHER_DESCRIPTION = 'other_description',
        CONTENT = 'content',
        REVIEW = 'review',
        OTHER = 'other';

    public static function getAll(): array
    {
        return [
            self::PRODUCT_TITLE,
            self::PRODUCT_DESCRIPTION,
            self::PRODUCT_DESCRIPTION2,
            self::PRODUCT_DESCRIPTION_SHORT,
            self::PRODUCT_PARAMETER,
            self::PRODUCT_DIMENSION_TABLE,
            self::PRODUCT_CATEGORY,
            self::TAG,
            self::OTHER_DESCRIPTION,
            self::CONTENT,
            self::REVIEW,
            self::OTHER,
        ];
    }
}
