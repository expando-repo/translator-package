<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Type\TextType;
use Expando\Translator\Type\Language;

class GroupRequest extends Base implements IRequest
{
    private string $text_type;
    private array $texts = [];
    private string $language_from;
    private string $language_to;
    private array $addon_data = [];

    private ?int $project_id = null;
    private ?string $custom_name = null;
    private ?string $custom_id = null;

    /**
     * @param int $project_id
     */
    public function setProjectId(int $project_id): void
    {
        $this->project_id = $project_id;
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

    public function addText(string $key, string $value)
    {
        $this->texts[$key] = $value;
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
     * @param int|null $custom_id
     */
    public function setCustomId(?int $custom_id): void
    {
        $this->custom_id = $custom_id;
    }

    /**
     * @param string $custom_name
     * @param string $custom_id
     */
    public function setCustom(string $custom_name, string $custom_id): void
    {
        $this->custom_name = $custom_name;
        $this->custom_id = $custom_id;
    }

    /**
     * @param string $custom_name
     * @param string $custom_id
     */
    public function setIdentifier(string $custom_name, string $custom_id): void
    {
        $this->setCustom($custom_name, $custom_id);
    }

    public function asArray(): array
    {
        return [
            'texts' => $this->texts,
            'custom_name' => $this->custom_name,
            'custom_id' => $this->custom_id,
            'text_type' => $this->text_type,
            'project_id' => $this->project_id,
            'language_from' => $this->language_from,
            'language_to' => $this->language_to,
            'addon_data' => $this->addon_data,
        ];
    }
}