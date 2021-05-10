<?php

namespace JoBins\APIGenerator\Services;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use JoBins\APIGenerator\Rules\RequiredRule;

trait ProcessRequestTrait
{
    /**
     * @var array
     */
    protected array $request;

    public function setRequest(array $request): self
    {
        $this->request = $request;

        return $this;
    }

    private function parseRequestBody(): ?array
    {
        if (Arr::get($this->request, "rule") == null) {
            return null;
        }

        return [
            "\$ref" => "#/components/requestBodies/".$this->getClassIdentifier(),
        ];
    }

    public function getClassIdentifier(): string
    {
        return md5($this->request["rule"]);
    }

    private function parseRequestBodies(): array
    {
        if (($className = Arr::get($this->request, "rule")) == null) {
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

    public function getParseRequestBodiesData(array $request): array
    {
        $data = [];
        $data["schema"] = [
            "required" => $this->getRequired($request),
            "properties" => $this->getProperties($request),
        ];

        if (! $this->request["ignoreData"]) {
            $data["example"] = $this->request["data"];
        }

        return $data;
    }

    private function getRequired(array $rules): Collection
    {
        return collect($rules)->filter(function (array $item) {
            return $item["required"] == true;
        })->keys();
    }

    public function getProperties(array $data): array
    {
        return collect($data)->map(function (array $value) {
            return Arr::except($value, "required");
        })->toArray();
    }

    private function processRequests(array $rules, array $description): array
    {
        $data = [];

        foreach ($rules as $name => $item) {
            $rulesArray = $item;

            if (! is_array($item)) {
                $rulesArray = explode("|", $item);
            }

            $data[$name] = [
                "required" => RequiredRule::check($rulesArray),
                "type" => in_array(["integer", "number"], $rulesArray) ? "integer" : "string",
                "description" => Arr::get($description, $name, ""),
            ];
        };

        return $data;
    }

    public function getRules(object $class): array
    {
        if (! method_exists($class, 'rules')) {
            return [];
        }

        return $class->rules();
    }

    public function getDescriptions(object $class): array
    {
        if (! method_exists($class, 'descriptions')) {
            return [];
        }

        return $class->descriptions();
    }
}
