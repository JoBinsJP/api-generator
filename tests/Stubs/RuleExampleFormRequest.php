<?php

namespace JoBins\APIGenerator\Tests\Stubs;

use Illuminate\Foundation\Http\FormRequest;

class RuleExampleFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            "name"      => "required",
            "full_name" => "sometimes|required",
            "last_name" => "nullable|required",
        ];
    }

    public function descriptions()
    {
        return [
            "name" => "Full name of a user",
        ];
    }
}
