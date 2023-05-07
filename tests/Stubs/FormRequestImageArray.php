<?php

namespace JoBins\APIGenerator\Tests\Stubs;

use Illuminate\Foundation\Http\FormRequest;
use JoBins\APIGenerator\Contract\Description;

/**
 * Class FormRequestImageArray
 */
class FormRequestImageArray extends FormRequest implements Description
{
    public function rules()
    {
        return [
            'profile' => 'required|image',
            'images' => 'nullable|sometimes|array|min:1|max:10',
            'images.*' => 'image',
            'keys' => 'array',
            'keys.*' => 'integer',
        ];
    }

    public function descriptions(): array
    {
        return [
            'profiles' => 'Profiles',
            'images' => 'Images only',
            'keys.*' => 'Asterik',
        ];
    }
}
