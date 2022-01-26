<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Product;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;
use Expando\Translator\Type\TextType;

class GetResponse implements IResponse
{
    protected ?string $product_id = null;
    protected ?string $title = null;
    protected ?string $description = null;
    protected ?string $description2 = null;
    protected ?string $description_short = null;
    protected string $language;
    protected int $word_count;
    protected string $status;
    protected string $hash;
    protected int $project_id;
    protected string $project_level;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['hash'] ?? null) === null) {
            throw new TranslatorException('Response product not return hash');
        }
        $this->status = $data['status'];
        $this->hash = $data['hash'];
        $this->product_id = $data['product_id'] ?? null;
        $this->language = $data['language'];
        $this->title = $data[TextType::PRODUCT_TITLE] ?? null;
        $this->description = $data[TextType::PRODUCT_DESCRIPTION] ?? null;
        $this->description2 = $data[TextType::PRODUCT_DESCRIPTION2] ?? null;
        $this->description_short = $data[TextType::PRODUCT_DESCRIPTION_SHORT] ?? null;
        $this->word_count = $data['word_count'] ?? 0;
        $this->project_id = $data['project_id'] ?? 0;
        $this->project_level = $data['project_level'] ?? 0;
    }

    /**
     * @return int|mixed
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * @return int|mixed|string
     */
    public function getProjectLevel()
    {
        return $this->project_level;
    }

    /**
     * @return int|mixed
     */
    public function getWordCount()
    {
        return $this->word_count;
    }

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->product_id;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return mixed|string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    /**
     * @return string|null
     */
    public function getDescriptionShort(): ?string
    {
        return $this->description_short;
    }

    /**
     * @return mixed|string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }
}