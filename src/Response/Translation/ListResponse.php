<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Translation;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;
use Expando\Translator\Response\Traits\PaginatorTrait;

class ListResponse implements IResponse
{
    use PaginatorTrait;

    /** @var GetResponse[]  */
    private array $translations = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['translations'] ?? null) === null) {
            throw new TranslatorException('Response translated text not return texts');
        }
        $this->status = $data['status'];
        foreach ($data['translations'] as $translation) {
            $this->translations[$translation['id']] = new GetResponse($translation);
        }
        $this->setPaginatorData($data['paginator'] ?? []);
    }

    /**
     * @return GetResponse[]
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
