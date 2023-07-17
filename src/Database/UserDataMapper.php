<?php

namespace TestClearPhp\Database;

use TestClearPhp\Model\User;

class UserDataMapper extends DataMapper
{
    public function mapFromArray(array $data): ?User
    {
        $user = new User();

        return $this->mapFromArrayToObject($data, $user);
    }

    /**
     * @param User $user
     */
    public function mapFromObject(object $user): array
    {
        return $this->mapFromObjectToArray($user);
    }
}
