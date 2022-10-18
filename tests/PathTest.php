<?php

namespace JoBins\APIGenerator\Tests;

use Illuminate\Support\Arr;
use JoBins\APIGenerator\Traits\HasDocsGenerator;

class PathTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_does_not_override_the_same_path_for_diff_method()
    {
        deleteDocs();

        $this->setSummary('User list API.')
            ->setId('Register')
            ->defineParameters([
                'id' => 'Numeric ID of user to get details',
            ])
            ->jsond('get', route('users.show', 1))
            ->generate($this, true);

        $this->setSummary('User list API.')
            ->setId('Register')
            ->defineParameters([
                'id' => 'Numeric ID of the user to delete',
            ])
            ->jsond('delete', route('users.show', 1), [])
            ->generate($this, true);

        $this->assertNotNull(getJsonForEndpoint(route('users.show', 1), 'get'));
        $this->assertNotNull(getJsonForEndpoint(route('users.destroy', 1), 'delete'));
    }

    /** @test */
    public function it_merges_the_params_same_path_for_same_path()
    {
        deleteDocs();

        $this->setSummary('User list API.')
            ->setId('Register')
            ->defineParameters([
                'id' => 'Numeric ID of user to get details',
            ])
            ->jsond('get', route('users.show', 1))
            ->generate($this, true);

        // Second operation should not override the first operation.
        $this->jsond('get', route('users.show', 1))
            ->generate($this, true);

        $json = getJsonForEndpoint(route('users.show', 1));

        $this->assertEquals('User list API.', Arr::get($json, 'summary'));
        $this->assertEquals('Register', Arr::get($json, 'operationId'));

        $this->assertEquals('Numeric ID of user to get details', Arr::get($json, 'parameters.0.description'));
    }
}
