<?php

namespace JoBins\APIGenerator\Tests;

use JoBins\APIGenerator\Rules\RequiredRule;

/**
 * Class RequireRuleTest
 * @package JoBins\APIGenerator\Tests
 */
class RequireRuleTest extends TestCase
{
    /**
     * @dataProvider requiredRuleDataProvider
     *
     * @test
     */
    public function test_required_rule($rules, $expected)
    {
        $this->assertEquals($expected, (new RequiredRule())->check($rules));
    }

    public function requiredRuleDataProvider()
    {
        return [
            [["required"], true],
            [["sometimes", "required"], false],
            [["nullable", "required"], false],
        ];
    }
}
