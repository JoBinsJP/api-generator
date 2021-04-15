<?php

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
        $this->setSummary("User list API.")
            ->setId("Register")
            ->setSecurity(Bearer::class)
            ->jsond("get", route("users.index"))
            ->assertStatus(200)
            ->generate($this, true);

//        $json = getJsonFromDocs();

//        $this->assertJsonFileEqualsJsonFile("",$json);
    }
}
