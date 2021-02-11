<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Type\TextType;

class TextRequest extends Base implements IRequest
{
    private string $text_type;
    private string $text;
    private string $language_from;
    private string $language_to;
    private array $addon_data = [];

    private ?int $project_id = null;
    private ?string $custom_name = null;
    private ?int $custom_id = null;

    /**
     * @param int|null $project_id
     */
    public function setProjectId(?int $project_id): void
    {
        $this->project_id = $project_id;
    }

    /**
     * @param string $text_type
     * @throws TranslatorException
     */
    public function setTextType(string $text_type): void
    {
        if (!in_array($text_type, TextType::getAll())) {
            throw new TranslatorException('Text type is not valid');
        }
        $this->text_type = $text_type;
    }

    /**
     * @param string|null $custom_name
     */
    public function setCustomName(?string $custom_name): void
    {
        $this->custom_name = $custom_name;
    }

    /**
     * @param int|null $custom_id
     */
    public function setCustomId(?int $custom_id): void
    {
        $this->custom_id = $custom_id;
    }

    /**
     * @param string $custom_name
     * @param int $custom_id
     */
    public function setCustom(string $custom_name, int $custom_id): void
    {
        $this->custom_name = $custom_name;
        $this->custom_id = $custom_id;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
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
     * @param array $addon_data
     */
    public function setAddonData(array $addon_data): void
    {
        $this->addon_data = $addon_data;
    }

    public function asArray(): array
    {
        return [
            'text_type' => $this->text_type,
            'custom_name' => $this->custom_name,
            'custom_id' => $this->custom_id,
            'project_id' => $this->project_id,
            'text' => $this->text,
            'language_from' => $this->language_from,
            'language_to' => $this->language_to,
            'addon_data' => $this->addon_data,
        ];
    }
}