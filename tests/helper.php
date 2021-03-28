<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Jobins\APIGenerator\Tests\Stubs\RuleExampleFormRequest;

function deleteDocs()
{
    $path = config()->get("api-generator.file-path");

    File::delete($path);
}

function getJsonFromDocs()
{
    $path = config()->get("api-generator.file-path");

    return json_decode(file_get_contents($path), true);
}

function getRequestBodyScheme($requestClass)
{
    $json = getJsonFromDocs();

    $requestId = md5($requestClass);

    return Arr::get($json, "components.requestBodies.{$requestId}.content.application/json");
}
