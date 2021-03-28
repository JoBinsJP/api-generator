<?php

namespace Jobins\APIGenerator\Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Jobins\APIGenerator\Tests\Stubs\NoDescriptionFormRequest;
use Jobins\APIGenerator\Tests\Stubs\RuleExampleFormRequest;
use Jobins\APIGenerator\Traits\HasDocsGenerator;

/**
 * Class FormRequestRuleTest
 * @package Jobins\APIGenerator\Tests
 */
class FormRequestRuleTest extends TestCase
{
    use HasDocsGenerator;

    /**
     * @dataProvider requiredRuleDataProvider
     *
     * @test
     */
    public function all_the__required_params_will_list_in_request_bodies($class, $required)
    {
        $path = config()->get("api-generator.file-path");

        File::delete($path);

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->setRulesFromFormRequest(RuleExampleFormRequest::class)
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $this->assertFileExists($path);

        $schema = getRequestBodyScheme(RuleExampleFormRequest::class);

        $this->assertEquals($required, Arr::get($schema, "schema.required"));
    }

    public function requiredRuleDataProvider()
    {
        return [
            [RuleExampleFormRequest::class, ["name"]],
        ];
    }
}
