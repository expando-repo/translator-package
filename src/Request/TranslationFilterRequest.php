<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Type\TextType;
use Expando\Translator\Type\Language;

class TranslationFilterRequest
{
    private ?string $language_from = null;
    private ?string $language_to = null;
    private ?string $fulltext = null;


    /**
     * @param string|null $language_from
     */
    public function setLanguageFrom(?string $language_from): void
    {
        $this->language_from = $language_from;
    }

    /**
     * @param string|null $language_to
     */
    public function setLanguageTo(?string $language_to): void
    {
        $this->language_to = $language_to;
    }

    /**
     * @param string|null $fulltext
     */
    public function setFulltext(?string $fulltext): void
    {
        $this->fulltext = $fulltext;
    }

    public function asArray(): array
    {
        return [
            'language_from' => $this->language_from,
            'language_to' => $this->language_to,
            'fulltext' => $this->fulltext,
        ];
    }
}
