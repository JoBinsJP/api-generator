<?php

namespace JoBins\APIGenerator\Tests\Rules;

use JoBins\APIGenerator\Rules\IntegerRule;
use JoBins\APIGenerator\Tests\TestCase;

/**
 * Class IntegerRuleTest
 */
class IntegerRuleTest extends TestCase
{
    /**
     * @dataProvider integerRuleDataProvider
     *
     * @test
     */
    public function it_validates_file($rules, $expected)
    {
        $this->assertEquals($expected, (new IntegerRule)->check($rules));
    }

    public function integerRuleDataProvider(): array
    {
        return [
            [['integer'], true],
        ];
    }
}
