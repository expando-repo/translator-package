<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Text;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class TranslatedResponse implements IResponse
{
    /** @var GetResponse[]  */
    private array $texts = [];
    private string $status;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['texts'] ?? null) === null) {
            throw new TranslatorException('Response translated text not return texts');
        }
        $this->status = $data['status'];
        foreach ($data['texts'] as $text) {
            $this->texts[$text['hash']] = new GetResponse($text);
        }
    }

    /**
     * @return GetResponse[]
     */
    public function getTexts(): array
    {
        return $this->texts;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}