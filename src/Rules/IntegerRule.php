<?php

namespace JoBins\APIGenerator\Rules;

class IntegerRule implements RuleContract
{
    /**
     * Rules that is valid for required.
     */
    const CONTAIN = ["integer"];

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

        if (count(array_intersect(self::CONTAIN, $rules)) > 0) {
            return true;
        }

        return false;
    }
}
