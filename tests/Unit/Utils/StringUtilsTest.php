<?php

namespace TestClearPhpTest\Unit\Utils;

use PHPUnit\Framework\TestCase;
use TestClearPhp\Utils\StringUtils;

class StringUtilsTest extends TestCase
{
    public function testFromSnakeCaseToCamelCase()
    {
        $input = 'hello_world';
        $expectedOutput = 'HelloWorld';
        $result = StringUtils::fromSnakeCaseToCamelCase($input);
        $this->assertEquals($expectedOutput, $result);
    }

    public function testFromCamelCaseToSnakeCase()
    {
        $input = 'HelloWorld';
        $expectedOutput = 'hello_world';
        $result = StringUtils::fromCamelCaseToSnakeCase($input);
        $this->assertEquals($expectedOutput, $result);
    }
}
