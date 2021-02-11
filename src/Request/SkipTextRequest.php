<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\IRequest;
use Expando\Translator\Type\SkipTextTag;

class SkipTextRequest extends Base implements IRequest
{
    private string $tag;
    private string $text;

    /**
     * @param string $text
     */
    public function setCustom(string $tag, string $text): void
    {
        $this->text = $text;
    }

    /**
     * @param string $text
     */
    public function setBrand(string $text): void
    {
        $this->tag = SkipTextTag::TAG_BRAND;
        $this->text = $text;
    }

    /**
     * @param string $text
     */
    public function setBand(string $text): void
    {
        $this->tag = SkipTextTag::TAG_BAND;
        $this->text = $text;
    }

    public function asArray(): array
    {
        return [
            'tag' => $this->tag,
            'text' => $this->text,
        ];
    }
}