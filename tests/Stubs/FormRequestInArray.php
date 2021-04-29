<?php

namespace JoBins\APIGenerator\Tests\Stubs;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FormRequestInArray
 *
 * @package JoBins\APIGenerator\Tests\Stubs
 */
class FormRequestInArray extends FormRequest
{
    public function rules()
    {
        return [
            "email" => ["required", new EmailRule],
        ];
    }
}

/**
 * Class EmailRule
 *
 * @package JoBins\APIGenerator\Tests\Stubs
 */
class EmailRule implements Rule
{
    public function passes($attribute, $value)
    {
    }

    public function message()
    {
    }
}
