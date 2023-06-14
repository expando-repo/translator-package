<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Project;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class GetResponse implements IResponse
{
    protected int $id;
    protected string $name;
    protected string $level;
    protected bool $default;
    protected string $user;

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
        $this->id = $data['id'];
        $this->user = $data['user'];
        $this->name = $data['name'];
        $this->level = $data['level'];
        $this->default = $data['default'];
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
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default;
    }
}