<?php

namespace JoBins\APIGenerator\Security;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait HasResponse
{
    public function processResponse()
    {
        $schemas = Arr::get($this->request, "responseSchema");

        $properties = Arr::get($schemas, "define", []);

        return collect($properties)->map(function ($properties, $attribute) use ($schemas) {
            $type = "object";

            $refSchemaName = Arr::get($properties, "refSchema");

            if ( Str::contains($attribute, "*") && $refSchemaName ) {
                return [
                    "type"  => "array",
                    "items" => [
                        "\$ref" => "#/components/schemas/{$refSchemaName}",
                    ],
                ];
            }

            if ( $refSchemaName ) {
                return [
                    "\$ref" => "#/components/schemas/{$refSchemaName}",
                ];
            }
            if ( $this->getSchemaName() && is_array($properties) ) {
                $schemaName = $this->getSchemaName();
                $this->defineSchema($schemaName, $type, $properties);

                return [
                    "\$ref" => "#/components/schemas/{$schemaName}",
                ];

            }

            return [
                "type"        => "string",
                "description" => $properties,
            ];
        })->toArray();
    }


    public function parseResponse($originalResponseData)
    {
        $code = $this->response->getStatusCode();

        $data = Arr::get($originalResponseData, $code, []);

        $schema     = [];
        $properties = $this->processResponse();
        if ( !empty($properties) ) {
            $schema["properties"] = $this->processResponse();
        }

        $example = json_decode($this->response->getContent(), true) ?? [];
        if ( !empty($example) ) {
            $schema["example"] = $example;
        }

        $responseData = [
            $code => [
                "description" => "{$code} status response",
                "content"     => [
                    "application/json" => [
                        "schema" => $schema,
                    ],
                ],
            ],
        ];

        return $responseData + $originalResponseData;
    }

    private function defineSchema(string $name, string $type, array $properties)
    {
        $schemaData = [
            "type"       => $type,
            "items"      => [
                "type" => "object",
            ],
            "properties" => $this->getSchemaProperties($properties),
        ];

        data_set($this->data, "components.schemas.{$name}", $schemaData);
    }

    private function getSchemaProperties($properties)
    {
        return collect($properties)->map(function ($definition, $key) {
            return [
                "type"        => "string",
                "description" => $definition,
            ];
        })->toArray();
    }

    private function getResponseSchemas()
    {
        $schemaName = $this->getSchemaName();

        $schemaData = [
            "type"       => "object",
            "properties" => $this->processResponse(),
        ];

        return "#/components/schemas/{$schemaName}";
    }

    /**
     * @return string|null
     */
    private function getSchemaName()
    {
        $schemas = Arr::get($this->request, "responseSchema");

        return Arr::get($schemas, "schema");
    }
}
