<?php

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Security\Bearer;
use JoBins\APIGenerator\Tests\TestCase;
use JoBins\APIGenerator\Traits\HasDocsGenerator;

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

        $this->setSummary('User list API.')
            ->setId('Register')
            ->setSecurity([Bearer::class])
            ->jsond('get', route('users.index'))
            ->assertStatus(200)
            ->generate($this, true);

        $json = getJsonForEndpoint(route('users.index'));

        $this->assertCount(1, Arr::get($json, 'security'));
    }
}
