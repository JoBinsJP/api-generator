<?php

use Illuminate\Support\Arr;
use Jobins\APIGenerator\Security\Bearer;
use Jobins\APIGenerator\Tests\TestCase;
use Jobins\APIGenerator\Traits\HasDocsGenerator;

/**
 * Class SecuritySchemaTest
 */
class SecuritySchemaTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_generates_security_schemas()
    {
        deleteDocs();

        $this->setSummary("User list API.")
            ->setId("Register")
            ->setSecurity([Bearer::class])
            ->jsond("get", route("users.index"))
            ->assertStatus(200)
            ->generate($this, true);

        $json = getJsonForEndpoint(route("users.index"));

        $this->assertCount(1, Arr::get($json,"security"));
    }
}
