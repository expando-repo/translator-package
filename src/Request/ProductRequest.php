<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Type\TextType;
use Expando\Translator\Type\Language;

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
     * @throws TranslatorException
     */
    public function setLanguageFrom(string $language_from): void
    {
        if (!in_array($language_from, Language::getAll())) {
            throw new TranslatorException('Language is not valid');
        }

        $this->language_from = $language_from;
    }

    /**
     * @param string $language_to
     * @throws TranslatorException
     */
    public function setLanguageTo(string $language_to): void
    {
        if (!in_array($language_to, Language::getAll())) {
            throw new TranslatorException('Language is not valid');
        }

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
            TextType::PRODUCT_TITLE => $this->title,
            TextType::PRODUCT_DESCRIPTION => $this->description,
            'language_from' => $this->language_from,
            'language_to' => $this->language_to,
            'addon_data' => $this->addon_data,
        ];
    }
}