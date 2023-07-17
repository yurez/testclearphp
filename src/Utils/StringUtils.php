<?php

namespace TestClearPhp\Utils;

class StringUtils
{
    public static function fromSnakeCaseToCamelCase(string $value): string
    {
        return str_replace('_', '', ucwords($value, '_'));
    }

    public static function fromCamelCaseToSnakeCase(string $value): string
    {
        $value = preg_replace('/(?!^)[[:upper:]]/', '_$0', $value);

        return strtolower($value);
    }
}
