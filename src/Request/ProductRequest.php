<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Type\TextType;
use Expando\Translator\Type\Language;

class ProductRequest extends Base implements IRequest
{
    private ?string $product_id = null;
    private ?int $project_id = null;
    private ?string $title = null;
    private ?string $additional_name = null;
    private ?string $description = null;
    private ?string $description2 = null;
    private ?string $description_short = null;
    private ?string $seo_title = null;
    private ?string $seo_description = null;
    private ?string $seo_url = null;
    private string $language_from;
    private string $language_to;
    private array $addon_data = [];
    private ?string $analysisHash = null;
    private ?array $customData = null;

    const
        CATEGORY_IMAGE_URL = 'image-url',
        CATEGORY_PRODUCT_URL = 'product-url'
    ;

    /**
     * @param string|null $analysisHash
     */
    public function setAnalysisHash(?string $analysisHash): void
    {
        $this->analysisHash = $analysisHash;
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addCustomData(string $key, string $value)
    {
        $this->customData[$key] = $value;
    }

    /**
     * @param string|null $product_id
     */
    public function setProductId(?string $product_id): void
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
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $title
     */
    public function setAdditionalName(?string $title): void
    {
        $this->additional_name = $title;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string|null $description2
     */
    public function setDescription2(?string $description2): void
    {
        $this->description2 = $description2;
    }

    /**
     * @param string|null $description_short
     */
    public function setDescriptionShort(?string $description_short): void
    {
        $this->description_short = $description_short;
    }

    /**
     * @param string|null $seo_title
     */
    public function setSeoTitle(?string $seo_title): void
    {
        $this->seo_title = $seo_title;
    }

    /**
     * @param string|null $seo_description
     */
    public function setSeoDescription(?string $seo_description): void
    {
        $this->seo_description = $seo_description;
    }

    /**
     * @param string|null $seo_url
     */
    public function setSeoUrl(?string $seo_url): void
    {
        $this->seo_url = $seo_url;
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

    /**
     * @param string $url
     */
    public function setProductUrl(string $url)
    {
        $this->addon_data[self::CATEGORY_PRODUCT_URL][] = $url;
    }

    public function asArray(): array
    {
        return [
            'product_id' => $this->product_id,
            'project_id' => $this->project_id,
            TextType::PRODUCT_TITLE => $this->title,
            TextType::PRODUCT_DESCRIPTION => $this->description,
            TextType::PRODUCT_DESCRIPTION2 => $this->description2,
            TextType::PRODUCT_DESCRIPTION_SHORT => $this->description_short,
            'additional_name' => $this->additional_name,
            'seo_product_title' => $this->seo_title,
            'seo_product_description' => $this->seo_description,
            'seo_product_url' => $this->seo_url,
            'language_from' => $this->language_from,
            'language_to' => $this->language_to,
            'addon_data' => $this->addon_data,
            'analysis_hash' => $this->analysisHash,
            'custom_data' => $this->customData,
        ];
    }
}
