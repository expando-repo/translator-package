<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

class GlossaryFilterRequest
{
    private ?string $fulltext = null;
    private ?string $languageSource = null;
    private ?string $languageTarget = null;

    /**
     * @param string|null $fulltext
     */
    public function setFulltext(?string $fulltext): void
    {
        $this->fulltext = $fulltext;
    }

    public function setLanguageSource(?string $languageSource): void
    {
        $this->languageSource = $languageSource;
    }

    public function setLanguageTarget(?string $languageTarget): void
    {
        $this->languageTarget = $languageTarget;
    }

    public function asArray(): array
    {
        return [
            'fulltext' => $this->fulltext,
            'language_source' => $this->languageSource,
            'language_target' => $this->languageTarget,
        ];
    }
}
