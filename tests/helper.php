<?php

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
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

function getSchema(string $name)
{
    $json = getJsonFromDocs();

    return Arr::get($json, "components.schemas.{$name}");
}

function getJsonForEndpoint(string $endpoint, $method = "get")
{
    $json = getJsonFromDocs();

    $route = Route::getRoutes()->match(Request::create($endpoint, $method));

    return Arr::get($json, "paths./{$route->uri()}.{$method}");
}
