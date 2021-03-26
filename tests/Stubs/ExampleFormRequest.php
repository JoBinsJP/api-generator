<?php

namespace Jobins\APIGenerator\Tests\Stubs;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ExampleFormRequest
 * @package Jobins\APIGenerator\Tests\Stubs
 */
class ExampleFormRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function descriptions()
    {
        return [

        ];
    }
}
