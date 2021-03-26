<?php

namespace Jobins\APIGenerator\Tests;

use Jobins\APIGenerator\Tests\Stubs\ExampleFormRequest;
use Jobins\APIGenerator\Traits\HasDocsGenerator;
use Illuminate\Support\Facades\File;

/**
 * Class GeneratorTest
 * @package Jobins\APIGenerator\Tests
 */
class FileSetupTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_generates_api_docs_if_file_does_not_exists()
    {
        $path = config()->get("api-generator.file-path");

        File::delete($path);

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->setRulesFromFormRequest(ExampleFormRequest::class)
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists($path);
    }

    /** @test */
    public function it_generates_api_docs_if_directory_does_not_exists()
    {
        $path = config()->get("api-generator.file-path");

        $directory = pathinfo($path)["dirname"];

        File::deleteDirectory($directory);

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->setRulesFromFormRequest(ExampleFormRequest::class)
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists($path);
    }
}
