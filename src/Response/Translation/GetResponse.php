<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Translation;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class GetResponse implements IResponse
{
    protected int $id;
    protected string $status;
    protected int $project_id;
    protected string $language_from;
    protected string $language_to;
    protected string $text_source;
    protected ?string $text_target;
    protected int $used_in_texts;
    protected int $checked;
    protected bool $is_import;
    protected ?string $level;
    protected array $texts;
    protected array $used_glossary = [];
    protected array $used_brands = [];
    protected bool $is_edited_by_user = false;
    protected string $translated_type;
    protected bool $translated_type_imported = false;

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
        $this->status = (string) $data['status'];
        $this->project_id = (int) $data['project_id'];
        $this->language_from = (string) $data['language_from'];
        $this->language_to = (string) $data['language_to'];
        $this->text_source = (string) $data['text_source'];
        $this->text_target = $data['text_target'];
        $this->used_in_texts = (int) $data['used_in_texts'];
        $this->checked = (int) $data['checked'];
        $this->level = (string) $data['level'];
        $this->is_import = (bool) $data['is_import'];
        $this->texts = (array) ($data['texts'] ?? []);
        $this->used_glossary = (array) $data['used_glossary'];
        $this->used_brands = (array) $data['used_brands'];
        $this->is_edited_by_user = (bool) $data['is_edited_by_user'];
        $this->translated_type = (string) $data['translated_type'];
        $this->translated_type_imported = (bool) $data['translated_type_imported'];
    }

    /**
     * @return bool
     */
    public function getTranslatedTypeImported(): bool
    {
        return $this->translated_type_imported;
    }

    /**
     * @return string
     */
    public function getTranslatedType(): string
    {
        return $this->translated_type;
    }

    /**
     * @return array
     */
    public function getUsedBrands(): array
    {
        return $this->used_brands;
    }

    /**
     * @return array
     */
    public function getUsedGlossary(): array
    {
        return $this->used_glossary;
    }

    /**
     * @return bool
     */
    public function getIsEditedByUser(): bool
    {
        return $this->is_edited_by_user;
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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->project_id;
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

    /**
     * @return int
     */
    public function getUsedInTexts(): int
    {
        return $this->used_in_texts;
    }

    /**
     * @return int
     */
    public function getChecked(): int
    {
        return $this->checked;
    }

    /**
     * @return ?string
     */
    public function getLevel(): ?string
    {
        return $this->level;
    }

    /**
     * @return array
     */
    public function getTexts(): array
    {
        return $this->texts;
    }

    public function isImport(): bool
    {
        return $this->is_import;
    }
}
