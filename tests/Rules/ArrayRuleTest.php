<?php

namespace JoBins\APIGenerator\Tests\Rules;

use JoBins\APIGenerator\Rules\ArrayRule;
use JoBins\APIGenerator\Tests\TestCase;

class ArrayRuleTest extends TestCase
{
    /**
     * @dataProvider arrayRuleDataProvider
     *
     * @test
     */
    public function it_validates_file($rules, $expected)
    {
        $this->assertEquals($expected, (new ArrayRule())->check($rules));
    }

    public function arrayRuleDataProvider(): array
    {
        return [
            [['array'], true],
        ];
    }
}
