<?php

namespace Jobins\APIGenerator\Tests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Jobins\APIGenerator\Tests\Stubs\FormRequestInArray;
use Jobins\APIGenerator\Tests\Stubs\NoDescriptionFormRequest;
use Jobins\APIGenerator\Traits\HasDocsGenerator;

/**
 * Class FormRequestTest
 *
 * @package Jobins\APIGenerator\Tests
 */
class FormRequestTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_generates_api_docs_even_if_form_request_does_not_exist()
    {
        deleteDocs();

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get("api-generator.file-path"));
    }

    /** @test */
    public function it_generates_api_docs_form_request_does_not_have_description_method()
    {
        deleteDocs();

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->setRulesFromFormRequest(NoDescriptionFormRequest::class)
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get("api-generator.file-path"));
    }

    /** @test */
    public function it_ignores_examples_if_it_set_to_ignore()
    {
        deleteDocs();

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->setRulesFromFormRequest(NoDescriptionFormRequest::class)
            ->ignoreRequestDataAsExample()
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get("api-generator.file-path"));
    }

    /** @test */
    public function it_supports_form_request_in_array_and_class()
    {
        deleteDocs();

        $this->setSummary("This is a example route")
            ->setId("FormRequestInArray")
            ->setRulesFromFormRequest(FormRequestInArray::class)
            ->ignoreRequestDataAsExample()
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get("api-generator.file-path"));
    }
}

