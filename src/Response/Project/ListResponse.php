<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Project;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class ListResponse implements IResponse
{
    /** @var GetResponse[]  */
    private array $projects = [];
    private string $status;

    /**
     * ListResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['projects'] ?? null) === null) {
            throw new TranslatorException('Response translated text not return texts');
        }
        $this->status = $data['status'];
        foreach ($data['projects'] as $project) {
            $this->projects[$project['id']] = new GetResponse($project);
        }
    }

    /**
     * @return GetResponse[]
     */
    public function getProjects(): array
    {
        return $this->projects;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}