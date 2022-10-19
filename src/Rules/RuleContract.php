<?php

namespace JoBins\APIGenerator\Rules;

/**
 * Interface RuleContract
 */
interface RuleContract
{
    public static function check(array $rules): bool;
}
