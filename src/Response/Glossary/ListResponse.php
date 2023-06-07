<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Glossary;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;
use Expando\Translator\Response\Traits\PaginatorTrait;

class ListResponse implements IResponse
{
    use PaginatorTrait;

    /** @var GetResponse[]  */
    private array $glossaryItems = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['glossaryItems'] ?? null) === null) {
            throw new TranslatorException('Response translated text not return texts');
        }
        $this->status = $data['status'];
        foreach ($data['glossaryItems'] as $glossary) {
            $this->glossaryItems[$glossary['id']] = new GetResponse($glossary);
        }
        $this->setPaginatorData($data['paginator'] ?? []);
    }

    /**
     * @return GetResponse[]
     */
    public function getGlossaryItems(): array
    {
        return $this->glossaryItems;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}
