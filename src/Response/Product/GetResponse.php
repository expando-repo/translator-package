<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Product;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class GetResponse implements IResponse
{
    protected ?int $product_id = null;
    protected ?string $title = null;
    protected ?string $description = null;
    protected string $language;
    protected string $status;
    protected string $hash;

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
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
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
     * @return mixed|string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }
}