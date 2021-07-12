<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Project;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class AnalysisResponse implements IResponse
{
    protected string $languageFrom;
    protected string $languageTo;
    protected int $wordCount;
    protected int $requestCount;
    protected int $productCount;
    protected int $repetitiveWordCountDictionary;
    protected int $repetitiveWordCountSelf;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['request_count'] ?? null) === null) {
            throw new TranslatorException('Response product not return request_count');
        }
        $this->languageFrom = $data['language_from'];
        $this->languageTo = $data['language_to'];
        $this->wordCount = $data['word_count'];
        $this->productCount = $data['product_count'];
        $this->requestCount = $data['request_count'];
        $this->repetitiveWordCountDictionary = $data['repetitive_word_count_dictionary'];
        $this->repetitiveWordCountSelf = $data['repetitive_word_count_self'];
    }

    /**
     * @return int|mixed
     */
    public function getRequestCount(): mixed
    {
        return $this->requestCount;
    }

    /**
     * @return int|mixed
     */
    public function getRepetitiveWordCountSelf(): mixed
    {
        return $this->repetitiveWordCountSelf;
    }

    /**
     * @return int|mixed
     */
    public function getRepetitiveWordCountDictionary(): mixed
    {
        return $this->repetitiveWordCountDictionary;
    }

    /**
     * @return int|mixed
     */
    public function getWordCount(): mixed
    {
        return $this->wordCount;
    }

    /**
     * @return int|mixed
     */
    public function getProductCount(): mixed
    {
        return $this->productCount;
    }

    /**
     * @return mixed|string
     */
    public function getLanguageFrom(): mixed
    {
        return $this->languageFrom;
    }

    /**
     * @return mixed|string
     */
    public function getLanguageTo(): mixed
    {
        return $this->languageTo;
    }
}
