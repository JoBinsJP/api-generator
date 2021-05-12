<?php

namespace JoBins\APIGenerator\Rules;

/**
 * Interface RuleContract
 *
 * @package JoBins\APIGenerator\Rules
 */
interface RuleContract
{
    public static function check(array $rules): bool;
}
