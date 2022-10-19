<?php

namespace JoBins\APIGenerator\Tests\Stubs;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FormRequestInArray
 */
class FormRequestInArray extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', new EmailRule],
        ];
    }
}

/**
 * Class EmailRule
 */
class EmailRule implements Rule
{
    public function message()
    {
    }

    public function passes($attribute, $value)
    {
    }
}
