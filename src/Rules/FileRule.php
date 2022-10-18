<?php

namespace JoBins\APIGenerator\Rules;

use Illuminate\Support\Str;

class FileRule implements RuleContract
{
    /**
     * Rules that is required to be File.
     */
    const CONTAIN = ['image'];

    /**
     * string that should be included to be a File.
     */
    const STR_INCLUDES = ['mimes', 'mimetypes', 'dimensions'];

    /**
     * @param  array  $rules
     * @return bool
     */
    public static function check(array $rules): bool
    {
        foreach ($rules as $rule) {
            if (method_exists($rule, '__toString')) {
                $rule = (string) $rule;
            }

            if (! is_string($rule)) {
                continue;
            }
            if (in_array($rule, self::CONTAIN)) {
                return true;
            }
            if (Str::contains($rule, self::STR_INCLUDES)) {
                return true;
            }
        }

        return false;
    }
}
