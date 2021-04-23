<?php

namespace Jobins\APIGenerator\Tests\Stubs;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FormRequestInArray
 *
 * @package Jobins\APIGenerator\Tests\Stubs
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
 * @package Jobins\APIGenerator\Tests\Stubs
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
