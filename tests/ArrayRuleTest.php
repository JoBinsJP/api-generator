<?php

namespace JoBins\APIGenerator\Tests;

use JoBins\APIGenerator\Rules\ArrayRule;

class ArrayRuleTest extends TestCase
{
    /**
     * @dataProvider arrayRuleDataProvider
     *
     * @test
     */
    public function it_validates_file($rules, $expected)
    {
        $this->assertEquals($expected, (new ArrayRule)->check($rules));
    }

    public function arrayRuleDataProvider(): array
    {
        return [
            [['array'], true],
        ];
    }
}
