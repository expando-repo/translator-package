<?php

declare(strict_types=1);

namespace Expando\Translator\Response;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class PostResponse implements IResponse
{
    private string $hash;

    /**
     * PostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['hash'] ?? null) === null) {
            throw new TranslatorException('Response not return hash');
        }
        $this->hash = $data['hash'];
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }
}