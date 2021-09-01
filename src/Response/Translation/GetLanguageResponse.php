<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Translation;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class GetLanguageResponse implements IResponse
{
    protected string $language;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['language'] ?? null) === null) {
            throw new TranslatorException('Response product not return id');
        }
        $this->language = $data['language'];
    }

    /**
     * @return mixed|string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}
