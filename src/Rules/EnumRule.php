<?php

namespace JoBins\APIGenerator\Rules;

use Illuminate\Support\Str;

class EnumRule implements RuleContract
{
    public static function check(array $rules): bool
    {
        foreach ($rules as $rule) {
            if (Str::contains($rule, 'in')) {
                return true;
            }
        }

        return false;
    }

    public static function data(array $rules): array
    {
        foreach ($rules as $rule) {
            if (Str::contains($rule, 'in')) {
                $enumRule = Str::replace('in:', '', $rule);

                return explode(',', $enumRule);
            }
        }

        return [];
    }
}
