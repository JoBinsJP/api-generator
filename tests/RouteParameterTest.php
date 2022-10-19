<?php

namespace JoBins\APIGenerator\Tests;

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Traits\HasDocsGenerator;

/**
 * Class RouteParameterTest
 */
class RouteParameterTest extends TestCase
{
    use HasDocsGenerator;

    public function setUp(): void
    {
        parent::setUp();

        deleteDocs();
    }

    /** @test */
    public function it_generates_route_parameters()
    {
        $this->setSummary('Register a new user.')
            ->setId('UserDetail')
            ->defineParameters([
                'id' => 'Numeric ID of the user to get',
            ])
            ->jsond('get', route('users.show', ['id' => 1, 'from' => '2020-12-12', 'to' => '2020-01-12']))
            ->assertStatus(200)
            ->generate($this, true);

        $json = getJsonFromDocs();
        $this->assertCount(3, Arr::get($json, 'paths./api/users/{id}.get.parameters') ?? []);
    }

    /** @test */
    public function it_generates_route_parameters_with_query()
    {
        $this->setSummary('Get a list of Users.')
            ->setId('UserList')
            ->defineParameters([
                'id' => 'Numeric ID of the user to get',
            ])
            ->jsond('get', route('users.index', ['from' => '2020-12-12', 'to' => '2020-01-12']))
            ->assertStatus(200)
            ->generate($this, true);

        $json = getJsonFromDocs();
        $this->assertCount(2, Arr::get($json, 'paths./api/users.get.parameters'));
    }
}
