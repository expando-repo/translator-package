<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Response\Product\GetResponse;
use Expando\Translator\Response\Product\PostResponse;
use Expando\Translator\Response\Product\TranslatedResponse;

class ProductRequest extends Base implements IRequest
{
    private ?int $product_id = null;
    private ?int $project_id = null;
    private string $title;
    private string $description;
    private string $language_from;
    private string $language_to;
    private array $addon_data = [];

    const
        CATEGORY_IMAGE_URL = 'image-url'
    ;

    /**
     * @param int|null $product_id
     */
    public function setProductId(?int $product_id): void
    {
        $this->product_id = $product_id;
    }

    /**
     * @param int $project_id
     */
    public function setProjectId(int $project_id): void
    {
        $this->project_id = $project_id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $language_from
     */
    public function setLanguageFrom(string $language_from): void
    {
        $this->language_from = $language_from;
    }

    /**
     * @param string $language_to
     */
    public function setLanguageTo(string $language_to): void
    {
        $this->language_to = $language_to;
    }

    /**
     * @param string $value
     */
    public function addImageUrl(string $value)
    {
        $this->addon_data[self::CATEGORY_IMAGE_URL][] = $value;
    }

    public function asArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'project_id' => $this->project_id,
            'title' => $this->title,
            'description' => $this->description,
            'language_from' => $this->language_from,
            'language_to' => $this->language_to,
            'addon_data' => $this->addon_data,
        ];
    }
}