<?php

use Illuminate\Support\Arr;
use Jobins\APIGenerator\Tests\Stubs\RuleExampleFormRequest;

function getRequestBodyScheme($requestClass)
{
    $path = config()->get("api-generator.file-path");

    $json = json_decode(file_get_contents($path), true);

    $requestId = md5($requestClass);

    return Arr::get($json, "components.requestBodies.{$requestId}.content.application/json");
}
