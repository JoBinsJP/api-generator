<?php

namespace JoBins\APIGenerator\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use JoBins\APIGenerator\Parser\RequestBodyComponent;
use JoBins\APIGenerator\Security\HasParameter;
use JoBins\APIGenerator\Security\HasResponse;
use JoBins\APIGenerator\Security\HasSecurity;
use JoBins\APIGenerator\Security\HasServer;

/**
 * Class Generator
 */
class Generator
{
    use ProcessRequestTrait;
    use HasParameter;
    use HasSecurity;
    use HasResponse;
    use HasServer;

    protected array $data = [];

    /** @var */
    protected $response = [];

    protected string $filePath = '';

    protected string $url = '';

    public function __construct()
    {
        $this->initializeFile();

        $this->data = array_merge($this->data, [
            'servers' => $this->processServer(config()->get('api-generator')),
            'openapi' => config()->get('api-generator.openapi'),
            'info' => [
                'title' => config()->get('api-generator.title'),
                'version' => config()->get('api-generator.version'),
            ],
        ]);
    }

    /**
     * Create a new file if not exists and assign existing data to $data property.
     */
    public function initializeFile(): void
    {
        $this->filePath = config()->get('api-generator.file-path');

        $path = pathinfo($this->filePath)['dirname'];

        if (! file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if (! File::exists($this->filePath)) {
            File::put($this->filePath, json_encode([]));
        }

        $this->data = json_decode(file_get_contents($this->filePath), true) ?? [];
    }

    public function setResponse($response): self
    {
        $this->response = $response;

        return $this;
    }

    public function generate(): void
    {
        $this->parseParam();

        File::put($this->filePath, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function getBasicPathInfo(array $pathData, $parameters): array
    {
        $responseData = Arr::get($pathData, 'responses', []);

        $return = $this->getBasicPathInfoData($responseData);

        data_set($return, 'parameters', $parameters);

        return $return;
    }

    public function getBasicPathInfoData($responseData)
    {
        $data = [];

        if ($security = $this->processSecurity($this->request)) {
            $data['security'] = $security;
        }

        $data['summary'] = $this->request['summary'];

        if ($tags = Arr::get($this->request, 'tags')) {
            $data['tags'] = $tags;
        }

        $data['operationId'] = $this->request['operationID'];

        if ($requestBody = $this->parseRequestBody()) {
            $data['requestBody'] = $requestBody;
        }

        $data['responses'] = $this->parseResponse($responseData);

        return $data;
    }

    private function parseParam()
    {
        [$url, $parameters] = $this->preparePathWithParam();
        $method = $this->request['method'];
        $pathKey = "paths.{$url}.{$method}";

        $pathData = Arr::get($this->data, $pathKey, []);
        $pathData = $pathData + $this->getBasicPathInfo($pathData, $parameters);

        data_set($this->data, $pathKey, $pathData);

        $requestBodies = Arr::get($this->data, 'components.requestBodies', []);

        $requestBodies = $requestBodies + (new RequestBodyComponent($this->request))->parseRequestBodies();

        if (! empty($requestBodies)) {
            data_set($this->data, 'components.requestBodies', $requestBodies);
        }
    }
}
