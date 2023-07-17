<?php

namespace TestClearPhp\Database;

interface DataMapperInterface
{
    public function mapFromArray(array $data): ?object;

    public function mapFromObject(object $object): array;
}
