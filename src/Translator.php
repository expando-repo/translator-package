<?php

declare(strict_types=1);

namespace Expando\Translator;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\Request\ProductRequest;
use Expando\Translator\Response\PostResponse;
use Expando\Translator\Response\Product\GetResponse;
use Expando\Translator\Response\Product\TranslatedResponse;

class Translator
{
    private array $token = [];
    private ?string $access_token = null;
    private ?string $refresh_token = null;
    private ?int $expires = null;
    private string $url = 'https://translator.expan.do';

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        if (!$this->access_token || !$this->refresh_token) {
            return false;
        }

        return true;
    }


    /**
     * @param ?array $token
     */
    public function setToken(?array $token): void
    {
        if ($token !== null) {
            $this->access_token = $token['access_token'] ?? null;
            $this->refresh_token = $token['refresh_token'] ?? null;
            $this->expires = $token['expires'] ?? null;
            $this->token = $token;
        }
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param IRequest $request
     * @return IResponse
     * @throws TranslatorException
     */
    public function send(IRequest $request): IResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        if ($request instanceof ProductRequest) {
            $data = $this->sendToTranslator('/products/', 'POST', $request->asArray());
            $result = new PostResponse($data);
        }
        else {
            throw new TranslatorException('Request not defined');
        }

        return $result;
    }

    /**
     * @param GetResponse $product
     * @return bool
     * @throws TranslatorException
     */
    public function commitProduct(GetResponse $product): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/products/commit/' . $product->getHash() . '/', 'PUT');
        return $data['status'] === 'success';
    }

    /**
     * @param string $hash
     * @return GetResponse
     * @throws TranslatorException
     */
    public function getProduct(string $hash): GetResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/products/' . $hash . '/', 'GET');
        return new GetResponse($data);
    }

    /**
     * @return TranslatedResponse
     * @throws TranslatorException
     */
    public function listTranslatedProduct(): TranslatedResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/products/translated/', 'GET');
        return new TranslatedResponse($data);
    }

    /**
     * @param string $action
     * @param $method
     * @param array $body
     * @return array
     * @throws TranslatorException
     */
    private function sendToTranslator(string $action, $method, array $body = []): array
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->access_token,
        );

        $ch = curl_init( $this->url . '/api' . $action);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($body) && $method === 'POST') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
        }
        $return = curl_exec($ch);
        curl_close($ch);

        if (!$return) {
            throw new TranslatorException('Translator did not return a correct response');
        }
        //print_r($return);
        $data = (array) json_decode($return, true);

        if (!$data || ($data['status'] ?? null) === null) {
            throw new TranslatorException('Response data is bad');
        }

        if ($data['status'] === 'error') {
            throw new TranslatorException('Response error: ' . ($data['message'] ?? null));
        }
        return $data;
    }
}
