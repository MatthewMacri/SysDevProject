<?php

namespace App\Http\Controllers\core;

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';

require_once config_path('config.php');

use PDO;
use PDOException;

class DatabaseController
{
    // Singleton instance of DatabaseController
    private static ?DatabaseController $instance = null;
    private PDO $connection;
    private static string $databasePath;

    /**
     * Private constructor to prevent direct instantiation.
     * Initializes the database connection.
     * 
     * @param string $databasePath Path to the SQLite database.
     */
    // Private constructor to prevent direct instantiation
    private function __construct()
    {
        if (!function_exists('database_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }

        if (empty(self::$databasePath)) {
            self::$databasePath = database_path('texasgears.db');
        }

        try {
            $this->connection = new PDO("sqlite:" . self::$databasePath);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->init();
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Returns the singleton instance of DatabaseController.
     * Ensures only one instance of DatabaseController is used.
     * 
     * @param string $databasePath Path to the SQLite database (default is 'database.sqlite').
     * @return self The singleton instance of DatabaseController.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Returns the PDO connection object.
     * 
     * @return PDO The PDO connection to the database.
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Initializes the database schema, creating tables if they do not exist.
     */
    public function init(): void
    {
        $pdo = $this->getConnection();

        // Array of SQL queries to create tables
        $queries = [

            "CREATE TABLE IF NOT EXISTS Users (
            user_id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_name VARCHAR(255),
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            email VARCHAR(255),
            password VARCHAR(255),
            is_deactivated BIT,
            twofa_secret VARCHAR(255),
            role VARCHAR(10)
        )",

            "CREATE TABLE IF NOT EXISTS Admins (
            admin_id INTEGER PRIMARY KEY AUTOINCREMENT,
            admin_name VARCHAR(255),
            first_name VARCHAR(255),
            last_name VARCHAR(255),
            email VARCHAR(255),
            password VARCHAR(255),
            twofa_secret VARCHAR(255),
            role VARCHAR(10)
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
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email VARCHAR(255) NOT NULL,
            token VARCHAR(255) NOT NULL,
            expires_at INTEGER NOT NULL
        )",
            "CREATE TABLE IF NOT EXISTS project_history (
            history_id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            admin_id INTEGER,
            project_id INTEGER NOT NULL,
            modification_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            modification_description VARCHAR(255) NOT NULL,
            FOREIGN KEY (user_id) REFERENCES Users(user_id),
            FOREIGN KEY (admin_id) REFERENCES Admins(admin_id),
            FOREIGN KEY (project_id) REFERENCES Project(project_id)
        )"
        ];

        foreach ($queries as $query) {
            $pdo->exec($query);
        }
    }

    /**
     * Selects all rows from a given table.
     * 
     * @param string $table The table to select from.
     * @return array The selected rows as an associative array.
     */
    public function selectAll(string $table): array
    {
        $stmt = $this->connection->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Inserts data into a specified table.
     * 
     * @param string $table The table to insert data into.
     * @param array $data An associative array of column names and values.
     * @return bool Whether the insert was successful.
     */
    public function insert(string $table, array $data): bool
    {
        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_map(fn($key) => ':' . $key, array_keys($data)));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute($data);
    }

    /**
     * Runs a custom query on the database.
     * 
     * @param string $sql The SQL query to execute.
     * @param array $params Parameters to bind to the query.
     * @return bool|array The result of the query, or false on failure.
     */
    public function runQuery(string $sql, array $params = []): bool|array
    {
        $stmt = $this->connection->prepare($sql);
        if ($stmt->execute($params)) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    /**
     * Saves a password reset token for a user.
     * 
     * @param string $email The email of the user requesting the reset.
     * @param string $token The reset token.
     * @param int $expiresAt The expiration time of the token.
     * @return bool Whether the token was saved successfully.
     */
    public function saveResetToken(string $email, string $token, int $expiresAt): bool
    {
        $sql = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([$email, $token, $expiresAt]);
    }

    /**
     * Retrieves a reset token from the database.
     * 
     * @param string $token The reset token to look for.
     * @return array|null The token data or null if not found.
     */
    public function getResetToken(string $token): ?array
    {
        $sql = "SELECT * FROM password_resets WHERE token = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([$token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Deletes a password reset token from the database.
     * 
     * @param string $token The reset token to delete.
     */
    public function deleteResetToken(string $token): void
    {
        $stmt = $this->connection->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
    }
}