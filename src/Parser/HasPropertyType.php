<?php

namespace JoBins\APIGenerator\Parser;

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Rules\ArrayRule;
use JoBins\APIGenerator\Rules\EnumRule;
use JoBins\APIGenerator\Rules\FileRule;
use JoBins\APIGenerator\Rules\IntegerRule;

/**
 * Trait HasPropertyType
 */
trait HasPropertyType
{
    /**
     * The rules of the request class.
     *
     * @var array
     */
    protected array $rulesArray = [];

    /**
     * @param  array  $rules
     * @param  string  $name
     *
     * @return array|string[]
     */
    public function getPropertyType(array $rules, string $name): array
    {
        if (ArrayRule::check($rules)) {
            $rules = Arr::get($this->rulesArray, "{$name}.*");

            return [
                'type'  => 'array',
                'items' => $this->getPropertyItemType($rules),
            ];
        }

        return $this->getPropertyItemType($rules);
    }

    /**
     * @param  array  $rulesArray
     */
    public function setRulesArray(array $rulesArray): void
    {
        $this->rulesArray = $rulesArray;
    }

    private function getPropertyItemType(array $rules): array
    {
        if (FileRule::check($rules)) {
            $this->contentType = 'multipart/form-data';

            return [
                'type'   => 'string',
                'format' => 'binary',
            ];
        }

        if (IntegerRule::check($rules)) {
            return [
                'type' => 'integer',
            ];
        }

        $enums = EnumRule::data($rules);
        if (count($enums) > 0) {
            return [
                'type' => 'string',
                'enum' => $enums,
            ];
        }

        return [
            'type' => 'string',
        ];
    }
}
