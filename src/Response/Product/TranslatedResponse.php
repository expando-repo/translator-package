<?php

declare(strict_types=1);

namespace Expando\Translator\Response\Product;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\IResponse;

class TranslatedResponse implements IResponse
{
    /** @var GetResponse[]  */
    private array $products = [];
    private string $status;

    /**
     * ProductPostResponse constructor.
     * @param array $data
     * @throws TranslatorException
     */
    public function __construct(array $data)
    {
        if (($data['products'] ?? null) === null) {
            throw new TranslatorException('Response translated product not return products');
        }
        $this->status = $data['status'];
        foreach ($data['products'] as $product) {
            $this->products[$product['hash']] = new GetResponse($product);
        }
    }

    /**
     * @return GetResponse[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return mixed|string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}