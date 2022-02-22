<?php

declare(strict_types=1);

namespace Expando\Translator\Request;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IRequest;
use Expando\Translator\Type\TextType;
use Expando\Translator\Type\Language;

class AnalysisRequest extends Base implements IRequest
{
    private array $productIds;
    private array $projectIds;
    private ?string $type = null;

    /**
     * @param array $productIds
     */
    public function setProductIds(array $productIds): void
    {
        $this->productIds = $productIds;
    }

    /**
     * @param array $projectIds
     */
    public function setProjectIds(array $projectIds): void
    {
        $this->projectIds = $projectIds;
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
            'product_ids' => $this->productIds,
            'project_ids' => $this->projectIds,
            'type' => $this->type,
        ];
    }
}
