<?php

namespace JoBins\APIGenerator\Security;

use Illuminate\Support\Arr;

trait HasSecurity
{
    public function processSecurity($request)
    {
        $securities = Arr::get($this->request, "security");

        if ( empty($securities) ) {
            return null;
        }

        return collect($securities)->map(function ($security) {
            $schema = (new $security)->getSchema();

            $this->ensureSecuritySchemaExists($schema);

            return [
                $schema["name"] => [],
            ];
        })->toArray();
    }

    public function ensureSecuritySchemaExists($schema)
    {
        $key = "components.securitySchemes.{$schema['name']}";

        if ( data_get($this->data, $key) ) {
            return;
        };

        data_set($this->data, $key, [
            "type"   => "http",
            "scheme" => "bearer",
        ]);
    }
}
