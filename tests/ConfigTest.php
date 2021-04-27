<?php

namespace JoBins\APIGenerator\Tests;

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Traits\HasDocsGenerator;

class ConfigTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_sets_correct_server_config()
    {
        deleteDocs();

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $json = getJsonFromDocs();

        $this->assertEquals("http://api.localhost.test", Arr::get($json, "servers.0.url"));
    }
}
