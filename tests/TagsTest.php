<?php

namespace Jobins\APIGenerator\Tests;

use Illuminate\Support\Arr;
use Jobins\APIGenerator\Traits\HasDocsGenerator;

class TagsTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_assigns_tags_to_endpoints()
    {
        deleteDocs();

        $this->setSummary("This is a example route")
            ->setId("ExampleRoute")
            ->setTags(["Posts"])
            ->jsond("post", route("posts.store"), [])
            ->generate($this, true);

        $json = getJsonForEndpoint(route("posts.store"), "post");

        $this->assertEquals(["Posts"], Arr::get($json, "tags"));
    }
}
