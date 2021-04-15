<?php

namespace Jobins\APIGenerator\Security;

use Illuminate\Support\Arr;

trait HasSecurity
{
    public function processSecurity($request)
    {
        $security = Arr::get($this->request, "security");

        if ( is_null($security) ) {
            return null;
        }

        $schema = (new $security)->getSchema();

        $this->ensureSecuritySchemaExists($schema);

        return [
            $schema["name"] => [],
        ];
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
