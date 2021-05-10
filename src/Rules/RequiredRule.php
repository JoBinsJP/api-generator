<?php

namespace JoBins\APIGenerator\Rules;

/**
 * Class RequiredRule
 * @package JoBins\APIGenerator\Rules
 */
class RequiredRule
{
    /**
     * Rules that is valid for required.
     */
    const CONTAIN = ["required"];

    /**
     * Rules that shouldn't present to be required.
     */
    const NOT_CONTAIN = ["sometimes", "nullable"];

    /**
     * @param array $rules
     *
     * @return bool
     */
    public static function check(array $rules): bool
    {
        $rules = collect($rules)->filter(function ($item) {
            return is_string($item);
        })->toArray();

        if (count(array_intersect(self::CONTAIN, $rules)) == 0) {
            return false;
        }

        if (count(array_intersect(self::NOT_CONTAIN, $rules)) > 0) {
            return false;
        }

        return true;
    }
}
