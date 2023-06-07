<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Glossary;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class GetResponse implements IResponse
{
    protected int $id;
    protected string $language_from;
    protected string $language_to;
    protected string $text_source;
    protected ?string $text_target;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['id'] ?? null) === null) {
            throw new TranslatorException('Response product not return id');
        }

        $this->id = (int) $data['id'];
        $this->language_from = (string) $data['language_from'];
        $this->language_to = (string) $data['language_to'];
        $this->text_source = (string) $data['text_source'];
        $this->text_target = $data['text_target'];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getLanguageFrom(): string
    {
        return $this->language_from;
    }

    /**
     * @return string
     */
    public function getLanguageTo(): string
    {
        return $this->language_to;
    }

    /**
     * @return string
     */
    public function getTextSource(): string
    {
        return $this->text_source;
    }

    /**
     * @return string|null
     */
    public function getTextTarget(): ?string
    {
        return $this->text_target;
    }
}
