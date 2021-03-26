<?php

namespace Jobins\APIGenerator\Tests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Jobins\APIGenerator\Tests\Stubs\NoDescriptionFormRequest;
use Jobins\APIGenerator\Traits\HasDocsGenerator;

/**
 * Class FormRequestTest
 * @package Jobins\APIGenerator\Tests
 */
class FormRequestTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_generates_api_docs_even_if_form_request_does_not_exist()
    {
        $path = config()->get("api-generator.file-path");

        File::delete($path);

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists($path);
    }

    /** @test */
    public function it_generates_api_docs_form_request_does_not_have_description_method()
    {
        $path = config()->get("api-generator.file-path");

        File::delete($path);

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->setRulesFromFormRequest(NoDescriptionFormRequest::class)
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists($path);
    }
}

