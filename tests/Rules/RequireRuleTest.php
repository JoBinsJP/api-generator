<?php

namespace JoBins\APIGenerator\Tests\Rules;

use JoBins\APIGenerator\Rules\RequiredRule;
use JoBins\APIGenerator\Tests\TestCase;

/**
 * Class RequireRuleTest
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
        $this->assertEquals($expected, (new RequiredRule)->check($rules));
    }

    public function requiredRuleDataProvider()
    {
        return [
            [['required'], true],
            [['sometimes', 'required'], false],
            [['nullable', 'required'], false],
        ];
    }
}
