<?php

namespace JoBins\APIGenerator\Tests\Rules;

use Illuminate\Validation\Rule;
use JoBins\APIGenerator\Rules\FileRule;
use JoBins\APIGenerator\Tests\TestCase;

/**
 * Class FileRuleTest
 */
class FileRuleTest extends TestCase
{
    /**
     * @dataProvider fileRuleDataProvider
     *
     * @test
     */
    public function it_validates_file($rules, $expected)
    {
        $this->assertEquals($expected, (new FileRule())->check($rules));
    }

    public function fileRuleDataProvider(): array
    {
        return [
            [['mimetypes:video/avi,video/mpeg,video/quicktime'], true],
            [['mimes:jpg,bmp,png'], true],
            [['image'], true],
            [['dimensions:ratio=3/2'], true],
            [[Rule::dimensions()->maxWidth(1000)->maxHeight(500)->ratio(3 / 2)], true],
        ];
    }
}
