<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Type\TextType;
use Expando\Translator\Type\Language;

class AnalysisRequest extends Base implements IRequest
{
    private array $productIds = [];
    private array $methods = [];
    private ?string $type = null;

    public function addMethod(int $projectId, string $languageFrom, string $languageTo)
    {
        $this->methods[] = [
            'project_id' => $projectId,
            'language_from' => $languageFrom,
            'language_to' => $languageTo,
        ];
    }

    /**
     * @param array $productIds
     */
    public function setProductIds(array $productIds): void
    {
        $this->productIds = $productIds;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function asArray(): array
    {
        return [
            'product_ids' => json_encode($this->productIds),
            'methods' => $this->methods,
            'type' => $this->type,
        ];
    }
}
