<?php

namespace Jobins\APIGenerator\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

/**
 * Class Generator
 * @package Jobins\APIGenerator
 */
class Generator
{
    use ProcessRequestTrait;

    protected $data = [];

    /** @var JsonResponse */
    protected $response;

    protected $filePath;

    protected $url;

    public function __construct()
    {
        $this->initializeFile();

        $this->data = array_merge($this->data, [
            "openapi" => config()->get("api-generator.openapi"),
            "info"    => [
                "title" => config()->get("api-generator.title"),
            ],
            "version" => config()->get("api-generator.version"),
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
        $data = Arr::get($this->data, "paths", []);

        $this->data["paths"] = array_merge($data, $this->getBasicPathInfo($data));

        $requestBodies = Arr::get($this->data, "components.requestBodies", []);

        $requestBodies = $requestBodies + $this->parseRequestBodies($requestBodies);

        data_set($this->data, "components.requestBodies", $requestBodies);
    }

    public function getBasicPathInfo($data)
    {
        $this->url = parse_url($this->request["url"], PHP_URL_PATH);

        $responseKey = $this->url.".".$this->request["method"].".responses";

        $responseData = Arr::get($data, $responseKey, []);

        return [
            $this->url => [
                $this->request["method"] => $this->getBasicPathInfoData($responseData),
            ],
        ];
    }

    public function getBasicPathInfoData($responseData)
    {
        $data                = [];
        $data["summary"]     = $this->request["summary"];
        $data["operationId"] = $this->request["operationID"];

        if ( $requestBody = $this->parseRequestBody() ) {
            $data["requestBody"] = $requestBody;
        }

        $data["responses"] = $this->parseResponse($responseData);

        return $data;
    }

    public function parseResponse($originalResponseData)
    {
        $code = $this->response->getStatusCode();

        $data = Arr::get($originalResponseData, $code, []);

        $responseData = [
            $code => [
                "content" => [
                    "application/json" => [
                        "schema"  => ["type" => "object"],
                        "example" => json_decode($this->response->getContent(), true),
                    ],
                ],
            ],
        ];

        return $responseData + $originalResponseData;
    }
}
