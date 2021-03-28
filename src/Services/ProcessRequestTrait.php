<?php

namespace Jobins\APIGenerator\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Jobins\APIGenerator\Rules\RequiredRule;

trait ProcessRequestTrait
{
    /**
     * @var array
     */
    protected $request;

    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    private function parseRequestBody()
    {
        return [
            "\$ref" => "#/components/requestBodies/".$this->getClassIdentifier(),
        ];
    }

    public function getClassIdentifier()
    {
        return md5($this->request["rule"]);
    }

    private function parseRequestBodies($requestBodies)
    {
        if ( ($className = Arr::get($this->request, "rule")) == null ) {
            return [];
        }

        /** @var FormRequest $class */
        $class = (new $className);

        $data = $this->processRequests($this->getRules($class), $this->getDescriptions($class));

        return [
            $this->getClassIdentifier() => [
                "content" => [
                    "application/json" => $this->getParseRequestBodiesData($data),
                ],
            ],
        ];
    }


    public function getParseRequestBodiesData($request)
    {
        $data           = [];
        $data["schema"] = [
            "required"   => $this->getRequired($request),
            "properties" => $this->getProperties($request),
        ];

        if ( !$this->request["ignoreData"] ) {
            $data["example"] = $this->request["data"];
        }

        return $data;

    }

    private function getRequired($rules)
    {
        return collect($rules)->filter(function ($item) {
            return $item["required"] == true;
        })->keys();
    }

    public function getProperties($data)
    {
        return collect($data)->map(function ($value, $key) {
            return Arr::except($value, "required");
        })->toArray();
    }

    private function processRequests($rules, array $description)
    {
        $data = [];

        foreach ($rules as $name => $item) {

            $rulesArray = explode("|", $item);

            $data[$name] = [
                "required"    => RequiredRule::check($rulesArray),
                "type"        => in_array(["integer", "number"], $rulesArray) ? "integer" : "string",
                "description" => Arr::get($description, $name, ""),
            ];
        };

        return $data;
    }

    public function getRules($class)
    {
        if ( !method_exists($class, 'rules') ) return [];

        return $class->rules();
    }

    public function getDescriptions($class)
    {
        if ( !method_exists($class, 'descriptions') ) return [];

        return $class->descriptions();
    }

}
