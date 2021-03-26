<?php

namespace Jobins\APIGenerator\Tests\Stubs;

use Illuminate\Foundation\Http\FormRequest;

class NoDescriptionFormRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }
}
