<?php

namespace JoBins\APIGenerator\Parser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JoBins\APIGenerator\Rules\RequiredRule;

/**
 * Class HasRequestBodies
 *
 * @package JoBins\APIGenerator\Security
 */
class RequestBodyComponent
{
    use HasPropertyType;

    /**
     * @var array
     */
    protected array $request;

    /**
     * @var string
     */
    protected string $contentType = "application/json";

    /**
     * ParseRequestBody constructor.
     *
     * @param array $request
     */
    public function __construct(array $request)
    {
        $this->request = $request;
    }

    public function getRules(object $class): array
    {
        if (! method_exists($class, 'rules')) {
            return [];
        }

        return collect($class->rules())->map(function ($item) {
            if (! is_array($item)) {
                return explode("|", $item);
            }

            return $item;
        })->toArray();
    }

    public function getDescriptions(object $class): array
    {
        if (! method_exists($class, 'descriptions')) {
            return [];
        }

        return $class->descriptions();
    }

    public function getParseSchema(array $request): array
    {
        $data = [];
        $data["schema"] = [
            "type" => "object",
            "required" => $this->getRequired($request),
            "properties" => $this->getProperties($request),
        ];

        if (! $this->request["ignoreData"]) {
            $data["example"] = $this->request["data"];
        }

        return $data;
    }

    public function parseRequestBodies(): array
    {
        if (($className = Arr::get($this->request, "rule")) == null) {
            return [];
        }

        /** @var FormRequest $class */
        $class = (new $className);

        // Set rules of a class for global access.
        $rules = $this->getRules($class);
        $this->setRulesArray($rules);

        $data = $this->processRequests($rules, $this->getDescriptions($class));

        return [
            getClassIdentifier($className) => [
                "content" => [
                    $this->contentType => $this->getParseSchema($data),
                ],
            ],
        ];
    }

    private function processRequests(array $rules, array $descriptions): array
    {
        $data = [];

        foreach ($rules as $name => $item) {

            // Ex. If image.* and image are present remove
            if (in_array(Str::slug($name), array_keys($data))) {
                continue;
            }

            $data[$name] = $this->getPropertyType($item, $name);

            $data[$name]["required"] = RequiredRule::check($item);

            if ($descriptionText = Arr::get($descriptions, $name)) {
                $data[$name]["description"] = $descriptionText;
            }
        };

        return $data;
    }

    private function getRequired(array $rules): Collection
    {
        return collect($rules)->filter(function (array $item) {
            return $item["required"] == true;
        })->keys();
    }

    private function getProperties(array $data): array
    {
        return collect($data)->map(function (array $value) {
            return Arr::except($value, "required");
        })->toArray();
    }
}
