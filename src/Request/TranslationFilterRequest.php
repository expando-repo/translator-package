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
    private ?string $textSource = null;
    private ?string $textTarget = null;
    private ?array $requestHashes = null;
    private ?string $tab = null;
    private bool $withTexts = false;
    private ?array $textTargets = null;

    public function setWithTexts(): void
    {
        $this->withTexts = true;
    }

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

    /**
     * @param string|null $textSource
     */
    public function setTextSource(?string $textSource): void
    {
        $this->textSource = $textSource;
    }

    /**
     * @param string|null $textTarget
     */
    public function setTextTarget(?string $textTarget): void
    {
        $this->textTarget = $textTarget;
    }

    /**
     * @param ?array $requestHashes
     */
    public function setRequestHash(?array $requestHashes): void
    {
        $this->requestHashes = $requestHashes;
    }

    /**
     * @param array|null $textTargets
     */
    public function setTextTargets(?array $textTargets = null): void
    {
        $this->textTargets = $textTargets;
    }

    /**
     * @param string|null $tab
     */
    public function setTab(?string $tab): void
    {
        $this->tab = $tab;
    }

    public function asArray(): array
    {
        return [
            'language_from' => $this->language_from,
            'language_to' => $this->language_to,
            'fulltext' => $this->fulltext,
            'text_source' => $this->textSource,
            'text_target' => $this->textTarget,
            'text_targets' => $this->textTargets,
            'request_hashes' => $this->requestHashes,
            'tab' => $this->tab,
            'with_texts' => $this->withTexts ? 1 : 0,
        ];
    }
}
