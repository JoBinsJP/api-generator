<?php

namespace JoBins\APIGenerator\Tests;

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Traits\HasDocsGenerator;

/**
 * Class ResponseSchemeTest
 *
 * @package JoBins\APIGenerator\Tests\Stubs
 */
class ResponseSchemeTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_generates_scheme_for_list_responses()
    {
        deleteDocs();

        $responseSchema = [
            "description" => "A User Object",
            "define" => [
                "data.*" => ["refSchema" => "UserSchema"],
                "message" => "Message for user",
            ],
        ];

        $this->setSummary("User list API.")
            ->setId("Register")
            ->defineResponseSchema($responseSchema)
            ->jsond("get", route("users.index"))
            ->generate($this, true);

        $json = getJsonForEndpoint(route("users.index"), "get");
        $json = Arr::get($json, "responses.200.content.application/json.schema");

        $this->assertCount(2, Arr::get($json, "properties"));
    }

    /** @test */
    public function it_generates_scheme_for_detail_responses()
    {
        deleteDocs();

        $responseSchema = [
            "schema" => "UserSchema",
            "description" => "A User Object",
            "define" => [
                "data" => [
                    "name" => "Full name of an User",
                    "email" => "Email of an User.",
                ],
            ],
        ];

        $this->setSummary("User list API.")
            ->setId("Register")
            ->defineResponseSchema($responseSchema)
            ->jsond("get", route("users.show", 1))
            ->generate($this, true);

        $json = getSchema("UserSchema");
        $this->assertCount(2, Arr::get($json, "properties"));
    }
}
