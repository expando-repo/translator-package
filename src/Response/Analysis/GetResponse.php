<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Analysis;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class GetResponse implements IResponse
{
    protected bool $success;
    protected array $summary;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['analysis_status'] ?? null) === null) {
            throw new TranslatorException('Response analysis not return data');
        }
        $this->success = $data['analysis_status'] === 'success';
        $this->summary = $data['summary'];
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return array|mixed
     */
    public function getSummary(): mixed
    {
        return $this->summary;
    }
}
