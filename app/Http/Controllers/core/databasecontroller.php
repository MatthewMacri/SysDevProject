<?php

namespace Controllers;

use PDO;
use PDOException;

class DatabaseController {
    private static ?DatabaseController $instance = null;
    private PDO $connection;

    // Private constructor to prevent direct instantiation
    private function __construct(string $databasePath = __DIR__ . 'database.sqlite')
    {
        try {
            $this->connection = new PDO("sqlite:" . $databasePath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Access point to the singleton instance, better encapsulation and more efficient when a singleton
    public static function getInstance(string $databasePath = 'database.sqlite'): self
    {
        if (self::$instance === null) {
            self::$instance = new self($databasePath);
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function init(): void {
        $pdo = $this->getConnection();
    
        $queries = [

        "CREATE TABLE IF NOT EXISTS Users (
            user_id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_name VARCHAR(255),
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            email VARCHAR(255),
            password VARCHAR(255),
            is_deactivated BIT
        )",

        "CREATE TABLE IF NOT EXISTS Admins (
            admin_id INTEGER PRIMARY KEY AUTOINCREMENT,
            admin_name VARCHAR(255),
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            email VARCHAR(255),
            password VARCHAR(255)
        )",

        "CREATE TABLE IF NOT EXISTS Client (
            client_id INTEGER PRIMARY KEY AUTOINCREMENT,
            client_name VARCHAR(255),
            company_name VARCHAR(255),
            email VARCHAR(255),
            client_phone_number VARCHAR(255)
        )",

        "CREATE TABLE IF NOT EXISTS Supplier (
            supplier_id INTEGER PRIMARY KEY AUTOINCREMENT,
            supplier_name VARCHAR(255),
            company_name VARCHAR(255),
            email VARCHAR(255),
            supplier_phone_number VARCHAR(255)
        )",

        "CREATE TABLE IF NOT EXISTS Project (
            project_id INTEGER PRIMARY KEY AUTOINCREMENT,
            serial_number VARCHAR(255),
            supplier_id INT,
            client_id INT,
            project_name VARCHAR(255),
            project_description VARCHAR(255),
            buffer_days INT,
            start_date TIMESTAMP,
            end_date TIMESTAMP,
            buffered_date TIMESTAMP,
            creation_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status TEXT,
            FOREIGN KEY (supplier_id) REFERENCES Supplier(supplier_id),
            FOREIGN KEY (client_id) REFERENCES Client(client_id)
        )",

        "CREATE TABLE IF NOT EXISTS Photo (
            photo_id INTEGER PRIMARY KEY AUTOINCREMENT,
            project_id INT,
            photo_url VARCHAR(255),
            format VARCHAR(50),
            upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            caption VARCHAR(255),
            FOREIGN KEY (project_id) REFERENCES Project(project_id)
        )",

        "CREATE TABLE IF NOT EXISTS Video (
            video_id INTEGER PRIMARY KEY AUTOINCREMENT,
            project_id INT,
            video_url VARCHAR(255),
            format VARCHAR(50),
            duration INT,
            upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (project_id) REFERENCES Project(project_id)
        )",

        "CREATE TABLE IF NOT EXISTS `Supplier-Project` (
            supplier_project_id INTEGER PRIMARY KEY AUTOINCREMENT,
            supplier_id INT,
            project_id INT,
            supplier_start_date TIMESTAMP,
            supplier_end_date TIMESTAMP,
            FOREIGN KEY (supplier_id) REFERENCES Supplier(supplier_id),
            FOREIGN KEY (project_id) REFERENCES Project(project_id)
        )",

        "CREATE TABLE IF NOT EXISTS password_resets (
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at INTEGER NOT NULL
        )"
        ];  

    
        foreach ($queries as $query) {
            $pdo->exec($query);
        }
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

    public function saveResetToken(string $email, string $token, int $expiresAt): bool
    {
        $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$email, $token, $expiresAt]);
    }

    public function getResetToken(string $token): ?array
    {
        $sql = "SELECT * FROM password_resets WHERE token = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function deleteResetToken(string $token): void
    {
        $stmt = $this->connection->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
    }
}
