<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Translation;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class ListLanguageResponse implements IResponse
{
    /** @var GetLanguageResponse[]  */
    private array $languages = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['languages'] ?? null) === null) {
            throw new TranslatorException('Response translated text not return texts');
        }
        $this->status = $data['status'];
        foreach ($data['languages'] as $language) {
            $this->languages[$language['language']] = new GetLanguageResponse($language);
        }
    }

    /**
     * @return GetLanguageResponse[]
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
