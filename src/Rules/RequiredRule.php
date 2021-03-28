<?php

namespace Jobins\APIGenerator\Rules;

/**
 * Class RequiredRule
 * @package Jobins\APIGenerator\Rules
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
     * @param $rules
     *
     * @return bool
     */
    public static function check($rules): bool
    {
        if ( count(array_intersect(self::CONTAIN, $rules)) == 0 ) {
            return false;
        }

        if ( count(array_intersect(self::NOT_CONTAIN, $rules)) > 0 ) {
            return false;
        }

        return true;
    }
}
