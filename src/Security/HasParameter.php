<?php

namespace Jobins\APIGenerator\Security;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

trait HasParameter
{
    public function preparePathWithParam(): array
    {
        $url    = Arr::get($this->request, "url");
        $method = Arr::get($this->request, "method");

        $route = Route::getRoutes()->match(Request::create($url, $method));

        parse_str(parse_url($url, PHP_URL_QUERY), $query);
        $queries = Arr::except($query, array_keys($route->parameters()));

        $parameters = $this->processQuery($queries) + $this->processParameters($route->parameters());

        return ["/".$route->uri(), array_values($parameters)];
    }

    public function processQuery(array $queries): array
    {
        $definitions = Arr::get($this->request, "definitions");

        return collect($queries)->map(function ($value, $param) use ($definitions) {
            return [
                "in"          => "query",
                "name"        => $param,
                "schema"      => [
                    "type" => is_numeric($value) ? "integer" : "string",
                ],
                "description" => Arr::get($definitions, $param),
            ];
        })->toArray();
    }

    /**
     * @param $parameters
     *
     * @return array
     */
    public function processParameters($parameters): array
    {
        $definitions = Arr::get($this->request, "definitions");

        return collect($parameters)->map(function ($value, $param) use ($definitions) {
            return [
                "in"          => "path",
                "name"        => $param,
                "schema"      => [
                    "type" => is_numeric($value) ? "integer" : "string",
                ],
                "required"    => true,
                "description" => Arr::get($definitions, $param),
            ];

        })->toArray();
    }
}
