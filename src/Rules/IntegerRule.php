<?php

namespace JoBins\APIGenerator\Rules;

class IntegerRule implements RuleContract
{
    /**
     * Rules that is valid for required.
     */
    const CONTAIN = ['integer'];

    public static function check(array $rules): bool
    {
        if (count(array_intersect(self::CONTAIN, $rules)) > 0) {
            return true;
        }

        return false;
    }
}
