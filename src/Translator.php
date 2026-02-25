<?php

declare(strict_types=1);

namespace Expando\Translator;

use Expando\Translator\Exceptions\TranslatorException;
use Expando\Translator\Exceptions\TranslatorNotFoundException;
use Expando\Translator\Request\AnalysisRequest;
use Expando\Translator\Request\GlossaryFilterRequest;
use Expando\Translator\Request\GroupRequest;
use Expando\Translator\Request\ProductRequest;
use Expando\Translator\Request\SkipTextRequest;
use Expando\Translator\Request\TextRequest;
use Expando\Translator\Request\TranslationFilterRequest;
use Expando\Translator\Response\PostResponse;
use Expando\Translator\Response\Product;
use Expando\Translator\Response\Project;
use Expando\Translator\Response\Translation;
use Expando\Translator\Response\Glossary;
use Expando\Translator\Response\Text;
use Expando\Translator\Response\Group;
use Expando\Translator\Response\Analysis;

class Translator
{
    private array $token = [];
    private ?string $access_token = null;
    private ?string $refresh_token = null;
    private ?int $expires = null;
    private string $url = 'https://translator-app.expan.do';

    /**
     * @return bool
     */
    public function isLogged(): bool
    {
        if (!$this->access_token) {
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
     * @return string[]
     */
    public function getToken(): array
    {
        return [
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires' => $this->expires,
            'token' => $this->token,
        ];
    }

    /**
     * @return bool
     */
    public function isTokenExpired()
    {
        if (!$this->expires) {
            return false;
        }
        return $this->isLogged() && $this->expires < time();
    }

    /**
     * @param int $clienId
     * @param string $clientSecret
     * @return array|null
     */
    public function refreshToken(int $clienId, string $clientSecret): ?array
    {
        $post = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refresh_token,
            'client_id' => $clienId,
            'client_secret' => $clientSecret,
            'scope' => '',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url . '/oauth/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($ch);
        curl_close($ch);

        $data = (array) json_decode($result);
        if ($data === false || ($data['error'] ?? null)) {
            $this->access_token = null;
            $this->refresh_token = null;
            $this->expires = null;
            $this->token = [];
            return null;
        }
        $this->setToken([
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires' => time() + $data['expires_in'],
        ]);
        return $data;
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
        else if ($request instanceof TextRequest) {
            $data = $this->sendToTranslator('/texts/', 'POST', $request->asArray());
            $result = new PostResponse($data);
        }
        else if ($request instanceof GroupRequest) {
            $data = $this->sendToTranslator('/groups/', 'POST', $request->asArray());
            $result = new PostResponse($data);
        }
        else if ($request instanceof AnalysisRequest) {
            $data = $this->sendToTranslator('/analysis/', 'POST', $request->asArray());
            $result = new PostResponse($data);
        }
        else {
            throw new TranslatorException('Request not defined');
        }

        return $result;
    }

    /**
     * @param IRequest $request
     * @return bool
     * @throws TranslatorException
     */
    public function add(IRequest $request): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        if ($request instanceof SkipTextRequest) {
            $data = $this->sendToTranslator('/skip-texts/', 'POST', $request->asArray());
        }
        else {
            throw new TranslatorException('Request not defined');
        }
        return $data['status'] === 'success';
    }

    /**
     * @param Product\GetResponse $product
     * @return bool
     * @throws TranslatorException
     */
    public function analysisReady(string $hash): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/analysis/ready/' . $hash . '/', 'PUT');
        return $data['status'] === 'success';
    }

    /**
     * @param Product\GetResponse $product
     * @return bool
     * @throws TranslatorException
     */
    public function commitProduct(Product\GetResponse $product): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/products/commit/' . $product->getHash() . '/', 'PUT');
        return $data['status'] === 'success';
    }

    /**
     * @param Text\GetResponse $text
     * @return bool
     * @throws TranslatorException
     */
    public function commitText(Text\GetResponse $text): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/texts/commit/' . $text->getHash() . '/', 'PUT');
        return $data['status'] === 'success';
    }

    /**
     * @param Group\GetResponse $text
     * @return bool
     * @throws TranslatorException
     */
    public function commitGroup(Group\GetResponse $text): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/groups/commit/' . $text->getHash() . '/', 'PUT');
        return $data['status'] === 'success';
    }

    /**
     * @param string $hash
     * @return Analysis\GetResponse
     * @throws TranslatorException
     */
    public function getAnalysisData(string $hash): Analysis\GetResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/analysis/' . $hash . '/', 'GET');
        return new Analysis\GetResponse($data);
    }

    /**
     * @param int $projectId
     * @return bool
     * @throws TranslatorException
     */
    public function deleteAnalysisData(int $projectId): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/project-analysis/delete/' . $projectId . '/', 'DELETE');
        return $data['status'] === 'success';
    }

    /**
     * @param string $hash
     * @return Product\GetResponse
     * @throws TranslatorException
     */
    public function getProduct(string $hash): Product\GetResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/products/' . $hash . '/', 'GET');
        return new Product\GetResponse($data);
    }

    /**
     * @param string $hash
     * @return Text\GetResponse
     * @throws TranslatorException
     */
    public function getText(string $hash): Text\GetResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/texts/' . $hash . '/', 'GET');
        return new Text\GetResponse($data);
    }

    /**
     * @return Project\ListResponse
     * @throws TranslatorException
     */
    public function listProjects(): Project\ListResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/projects/', 'GET');

        return new \Expando\Translator\Response\Project\ListResponse($data);
    }

    /**
     * @param string $hash
     * @return Group\GetResponse
     * @throws TranslatorException
     */
    public function getGroup(string $hash): Group\GetResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/groups/' . $hash . '/', 'GET');
        return new Group\GetResponse($data);
    }

    /**
     * @return Product\TranslatedResponse
     * @throws TranslatorException
     */
    public function listTranslatedProducts(): Product\TranslatedResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/products/translated/', 'GET');
        return new Product\TranslatedResponse($data);
    }

    /**
     * @return Text\TranslatedResponse
     * @throws TranslatorException
     */
    public function listTranslatedTexts(): Text\TranslatedResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/texts/translated/', 'GET');
        return new Text\TranslatedResponse($data);
    }

    /**
     * @return Group\TranslatedResponse
     * @throws TranslatorException
     */
    public function listTranslatedGroups(): Group\TranslatedResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/groups/translated/', 'GET');
        return new Group\TranslatedResponse($data);
    }

    /**
     * @return Translation\ListResponse
     * @throws TranslatorException
     */
    public function listTranslations(int $page = 1, int $onPage = 20, ?string $sort = null, ?bool $sortDesc = null, ?TranslationFilterRequest $filter = null): Translation\ListResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/translations/', 'GET', array_filter([
            'page' => $page,
            'on-page' => $onPage,
            'sort' => $sort,
            'sort-desc' => $sortDesc !== null ? (int) $sortDesc : null,
            'filter' => $filter ? array_filter($filter->asArray()) : [],
        ]));
        return new Translation\ListResponse($data);
    }

    public function listGlossaryItems(int $page = 1, int $onPage = 20, ?GlossaryFilterRequest $filter = null): Glossary\ListResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/glossary/', 'GET', array_filter([
            'page' => $page,
            'on-page' => $onPage,
            'filter' => $filter ? array_filter($filter->asArray()) : [],
        ]));
        return new Glossary\ListResponse($data);
    }

    /**
     * @param string $hash
     * @return Translation\GetResponse
     * @throws TranslatorException
     */
    public function getTranslation(int $id): Translation\GetResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/translations/' . $id . '/', 'GET');
        return new Translation\GetResponse($data);
    }

    /**
     * @return Translation\ListLanguageResponse
     * @throws TranslatorException
     */
    public function listTranslationLanguages(): Translation\ListLanguageResponse
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/translations/languages/', 'GET');
        return new Translation\ListLanguageResponse($data);
    }

    /**
     * @param int $id
     * @return bool
     * @throws TranslatorException
     */
    public function checkedTranslation(int $id): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/translations/checked/' . $id . '/', 'PUT');
        return $data['status'] === 'success';
    }

    /**
     * @param int $id
     * @param string $textTarget
     * @return bool
     * @throws TranslatorException
     */
    public function updateTranslation(int $id, string $textTarget, ?string $auto_translator = null): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/translations/update/' . $id . '/', 'PUT', [
            'text_target' => $textTarget,
            'auto_translator' => $auto_translator,
        ]);
        return $data['status'] === 'success';
    }

    /**
     * @param int $id
     * @return bool
     * @throws TranslatorException
     */
    public function deleteTranslation(int $id): bool
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/translations/delete/' . $id . '/', 'DELETE');
        return $data['status'] === 'success';
    }

    /**
     * @param array $data
     * @return array
     * @throws TranslatorException
     */
    public function updateClientTranslationSetting(array $data): array
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/update-client-translate-setting', 'POST', ['data' => $data]);

        return $data['data'] ?? [];
    }

    /**
     * @param array|null $keys
     * @return array
     * @throws TranslatorException
     */
    public function clientTranslationSetting(?array $keys = null): array
    {
        if (!$this->isLogged()) {
            throw new TranslatorException('Translator is not logged');
        }

        $data = $this->sendToTranslator('/client-translate-setting', 'GET');

        return $data['data'] ?? [];
    }


    /**
     * @param string $action
     * @param $method
     * @param array $body
     * @return array
     * @throws TranslatorException
     */
    public function sendToTranslator(string $action, $method, array $body = [], int $try = 0): array
    {
        $headers = array(
            'Content-Type' => 'application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $this->access_token,
        );

        $url = $this->url . '/api' . $action;
        if (!empty($body) && $method === 'GET') {
            $url .= '?' . http_build_query($body);
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($body) && in_array($method, ['POST', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
        }
        $return = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if (!$return) {
            if ($httpcode == 0 && $try < 3) {
                sleep($try + rand(1,5));
                return $this->sendToTranslator($action, $method, $body, ++$try);
            }
            throw new TranslatorException('Translator did not return a correct response (code: ' . $httpcode . ')');
        }
        if ($_GET['debug'] ?? null) {
            echo '<pre>';
            print_r($return);
        }
        $data = (array) json_decode($return, true);

        if (!$data || ($data['status'] ?? null) === null) {
            if (class_exists('\Log')) {
                \Log::error('Translator-Package error: ', ['curl_info' => $info, 'request' => $url, 'body' => $body, 'response' => $return]);
            }
            $message = ($data['message'] ?? null);
            throw new TranslatorException('Response data is bad' . ($message ? ' ('.$message.')' : ''));
        }

        if ($data['status'] === 'error') {
            // Log error if logging is available
            if (class_exists('\Log')) {
                \Log::error(__FILE__.':'.__LINE__, ['curl_info' => $info, 'request' => $url, 'body' => $body, 'response' => $return]);
            }
            if ($httpcode == 404) {
                throw new TranslatorNotFoundException($data['message'] ?? 'Not found');
            } else {
                throw new TranslatorException('Response error: ' . ($data['message'] ?? null));
            }
        }
        return $data;
    }
}
