<?php

namespace TestClearPhp\Database;

use TestClearPhp\Utils\StringUtils;

abstract class DataMapper implements DataMapperInterface
{
    protected function mapFromArrayToObject(array $data, object $object): ?object
    {
        if (empty($data)) {
            return null;
        }

        foreach ($data as $key => $value) {
            $setter = 'set' . StringUtils::fromSnakeCaseToCamelCase($key);
            if(method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }

        return $object;
    }

    protected function mapFromObjectToArray(object $object): array
    {
        $objectArray = (array) $object;
        $data = [];

        foreach ($objectArray as $key => $value) {
            $key = preg_replace('/[^a-zA-Z0-9]/', '', $key);
            $key = StringUtils::fromCamelCaseToSnakeCase($key);

            $data[$key] = $value;
        }

        return $data;
    }
}
