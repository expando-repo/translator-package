<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Group;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class GetResponse implements IResponse
{
    protected ?string $custom_id = null;
    protected ?string $custom_name = null;
    protected array $texts = [];
    protected string $language;
    protected int $word_count;
    protected array $translateData = [];
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
        $this->language = $data['language'];
        $this->custom_id = $data['custom_id'] ?? null;
        $this->custom_name = $data['custom_name'] ?? null;
        $this->texts = $data['texts'] ?? [];
        $this->word_count = $data['word_count'] ?? 0;
        $this->translateData = $data['translate_data'] ?? [];
        $this->project_id = $data['project_id'] ?? 0;
        $this->project_level = $data['project_level'] ?? '';
    }

    /**
     * @return array
     */
    public function getTranslateData(): array
    {
        return $this->translateData;
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
     * @return string|mixed|null
     */
    public function getCustomId(): ?string
    {
        return $this->custom_id;
    }

    /**
     * @return mixed|string|null
     */
    public function getCustomName(): ?string
    {
        return $this->custom_name;
    }

    /**
     * @return array
     */
    public function getTexts(): array
    {
        return $this->texts;
    }

    /**
     * @return mixed|string
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
     * @return mixed|string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }
}