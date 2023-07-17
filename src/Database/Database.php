<?php

namespace TestClearPhp\Database;

use PDO;

class Database
{
    private PDO $connection;

    public function __construct(string $host, string $dbname, string $username, string $password)
    {
        $this->connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function execute(string $sql, array $params = []): bool
    {
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute($params);
    }

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
