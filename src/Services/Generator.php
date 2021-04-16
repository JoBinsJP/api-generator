<?php

namespace Jobins\APIGenerator\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Jobins\APIGenerator\Security\HasParameter;
use Jobins\APIGenerator\Security\HasResponse;
use Jobins\APIGenerator\Security\HasSecurity;

/**
 * Class Generator
 * @package Jobins\APIGenerator
 */
class Generator
{
    use ProcessRequestTrait,
        HasParameter,
        HasSecurity,
        HasResponse;

    protected $data = [];

    /** @var JsonResponse */
    protected $response;

    protected $filePath;

    protected $url;

    public function __construct()
    {
        $this->initializeFile();

        $this->data = array_merge($this->data, [
            "servers" => [
                [
                    "url" => config()->get("api-generator.servers.url"),
                ],
            ],
            "openapi" => config()->get("api-generator.openapi"),
            "info"    => [
                "title"   => config()->get("api-generator.title"),
                "version" => config()->get("api-generator.version"),
            ],
        ]);
    }

    /**
     * Create a new file if not exists and assign existing data to $data property.
     */
    public function initializeFile()
    {
        $this->filePath = config()->get("api-generator.file-path");

        $path = pathinfo($this->filePath)["dirname"];

        if ( !file_exists($path) ) {
            mkdir($path, 0777, true);
        }

        if ( !File::exists($this->filePath) ) {
            File::put($this->filePath, json_encode([]));
        }

        $this->data = json_decode(file_get_contents($this->filePath), true) ?? [];
    }


    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    public function generate()
    {
        $this->parseParam();

        File::put($this->filePath, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function parseParam()
    {
        [$url, $parameters] = $this->preparePathWithParam();
        $method  = $this->request["method"];
        $pathKey = "paths.{$url}.{$method}";

        $pathData = Arr::get($this->data, $pathKey, []);
        $pathData = $pathData + $this->getBasicPathInfo($pathData, $parameters);

        data_set($this->data, $pathKey, $pathData);


        $requestBodies = Arr::get($this->data, "components.requestBodies", []);

        $requestBodies = $requestBodies + $this->parseRequestBodies($requestBodies);

        if ( !empty($requestBodies) ) {
            data_set($this->data, "components.requestBodies", $requestBodies);
        }
    }

    public function getBasicPathInfo($pathData, $parameters)
    {
        $responseData = Arr::get($pathData, "responses", []);

        $return = $this->getBasicPathInfoData($responseData);

        data_set($return, "parameters", $parameters);

        return $return;
    }

    public function getBasicPathInfoData($responseData)
    {
        $data = [];

        if ( $security = $this->processSecurity($this->request) ) {
            $data["security"] = $security;
        }

        $data["summary"] = $this->request["summary"];

        if ( $tags = Arr::get($this->request, "tags") ) {
            $data["tags"] = $tags;
        }

        $data["operationId"] = $this->request["operationID"];

        if ( $requestBody = $this->parseRequestBody() ) {
            $data["requestBody"] = $requestBody;
        }

        $data["responses"] = $this->parseResponse($responseData);

        return $data;
    }
}
