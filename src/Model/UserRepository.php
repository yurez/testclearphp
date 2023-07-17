<?php

namespace TestClearPhp\Model;

use TestClearPhp\Database\Database;
use TestClearPhp\Database\UserDataMapper;
use TestClearPhp\Exception\RecordNotFoundException;

class UserRepository
{
    public function __construct(
        protected Database $database,
        protected UserDataMapper $dataMapper
    ) {}

    public function findByEmail(string $email): ?User
    {
        $sql = 'SELECT * FROM `user` WHERE `email` = :email LIMIT 1';
        $params = ['email' => $email];

        $result = $this->database->query(
            $sql,
            $params
        );

        if (!empty($result)) {
            return $this->dataMapper->mapFromArray($result[0]);
        }

        return null;
    }

    public function findById(int $id): ?User
    {
        $sql = 'SELECT * FROM `user` WHERE `id` = :id LIMIT 1';
        $params = ['id' => $id];

        $result = $this->database->query(
            $sql,
            $params
        );

        if (!empty($result)) {
            return $this->dataMapper->mapFromArray($result[0]);
        }

        return null;
    }

    /**
     * @throws RecordNotFoundException
     */
    public function saveUser(User $user): User
    {
        if ($user->getId()) {
            if(!$this->findById($user->getId())) {
                throw new RecordNotFoundException('User not found for update');
            }

            return $this->updateUser($user);
        }

        return $this->createUser($user);
    }

    protected function createUser(User $user): User
    {
        $data = $this->dataMapper->mapFromObject($user);
        unset($data['id']); // Remove the ID to prevent overwriting


        $sql = 'INSERT INTO `user` (`email`, `password`, `first_name`, `last_name`, `phone`) 
            VALUES (:email, :password, :first_name, :last_name, :phone)';

        $this->database->execute($sql, $data);

        $userId = $this->database->getConnection()->lastInsertId();
        $user->setId($userId);

        return $user;
    }

    protected function updateUser(User $user): User
    {
        $data = $this->dataMapper->mapFromObject($user);

        $sql = 'UPDATE `user` 
            SET `email` = :email, `password` = :password, `first_name` = :first_name, 
                `last_name` = :last_name, `phone` = :phone
            WHERE `id` = :id';

        $this->database->execute($sql, $data);

        return $user;
    }
}
