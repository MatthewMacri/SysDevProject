<?php

namespace Controllers;

use PDO;
use PDOException;

class DatabaseController {
    private PDO $connection;

    public function __construct(string $databasePath = 'database.sqlite')
    {
        try {
            $this->connection = new PDO("sqlite:" . $databasePath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function selectAll(string $table): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($key) => ':' . $key, array_keys($data)));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute($data);
    }

    public function runQuery(string $sql, array $params = []): bool|array
    {
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute($params)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }
}
