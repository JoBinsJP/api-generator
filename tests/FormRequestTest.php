<?php

namespace JoBins\APIGenerator\Tests;

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Tests\Stubs\FormRequestImageArray;
use JoBins\APIGenerator\Tests\Stubs\FormRequestInArray;
use JoBins\APIGenerator\Tests\Stubs\NoDescriptionFormRequest;
use JoBins\APIGenerator\Traits\HasDocsGenerator;

/**
 * Class FormRequestTest
 */
class FormRequestTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_generates_api_docs_even_if_form_request_does_not_exist()
    {
        deleteDocs();

        $this->setSummary('This is a example route')
            ->setId('ExampleRoute')
            ->jsond('post', route('posts.store'), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get('api-generator.file-path'));
    }

    /** @test */
    public function it_generates_api_docs_form_request_does_not_have_description_method()
    {
        deleteDocs();

        $this->setSummary('This is a example route')
            ->setId('ExampleRoute')
            ->setRulesFromFormRequest(NoDescriptionFormRequest::class)
            ->jsond('post', route('posts.store'), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get('api-generator.file-path'));
    }

    /** @test */
    public function it_ignores_examples_if_it_set_to_ignore()
    {
        deleteDocs();

        $this->setSummary('This is a example route')
            ->setId('ExampleRoute')
            ->setRulesFromFormRequest(NoDescriptionFormRequest::class)
            ->ignoreRequestDataAsExample()
            ->jsond('post', route('posts.store'), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get('api-generator.file-path'));
    }

    /** @test */
    public function it_supports_form_request_in_array_and_class()
    {
        deleteDocs();

        $this->setSummary('This is a example route')
            ->setId('FormRequestInArray')
            ->setRulesFromFormRequest(FormRequestInArray::class)
            ->ignoreRequestDataAsExample()
            ->jsond('post', route('posts.store'), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get('api-generator.file-path'));
    }

    /** @test */
    public function it_supports_array_type_data_in_rules()
    {
        deleteDocs();

        $this->setSummary('This is a example route')
            ->setId('FormRequestImageArray')
            ->setRulesFromFormRequest(FormRequestImageArray::class)
            ->ignoreRequestDataAsExample()
            ->jsond('post', route('posts.store'), [])
            ->generate($this, true);

        $this->assertFileExists(config()->get('api-generator.file-path'));

        $schema = getRequestBodyScheme(FormRequestImageArray::class, 'multipart/form-data');

        $properties = Arr::get($schema, 'schema.properties');

        $this->assertEquals('array', Arr::get($properties, 'images.type'));
        $this->assertEquals(['type' => 'string', 'format' => 'binary'], Arr::get($properties, 'images.items'));

        $this->assertEquals('array', Arr::get($properties, 'keys.type'));
        $this->assertEquals(['type' => 'integer'], Arr::get($properties, 'keys.items'));
    }
}
