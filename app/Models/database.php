<?php
namespace App\Models;

class Database {
    public function connect() {
        return new \PDO("sqlite:" . __DIR__ . "/../../database/Data.db");
    }
}