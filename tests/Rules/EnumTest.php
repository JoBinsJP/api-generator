<?php

namespace JoBins\APIGenerator\Tests\Rules;

use JoBins\APIGenerator\Rules\EnumRule;
use JoBins\APIGenerator\Tests\TestCase;
use JoBins\APIGenerator\Traits\HasDocsGenerator;

class EnumTest extends TestCase
{
    use HasDocsGenerator;

    /** @test */
    public function it_detects_enum_rules()
    {
        $this->assertTrue(EnumRule::check(['in:football,volleyball']));
        $this->assertEquals(['football', 'volleyball'], EnumRule::data(['in:football,volleyball']));
    }
}
