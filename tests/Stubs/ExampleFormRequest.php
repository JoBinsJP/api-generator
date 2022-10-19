<?php

namespace JoBins\APIGenerator\Tests\Stubs;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ExampleFormRequest
 */
class ExampleFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category' => 'required|in:football,cricket',
        ];
    }

    public function descriptions()
    {
        return [

        ];
    }
}
