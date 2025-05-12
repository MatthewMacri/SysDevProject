<?php

namespace App\Models;

class Database
{
    /**
     * Establishes a connection to the SQLite database.
     *
     * This method creates and returns a new PDO instance that connects
     * to the SQLite database. The database file is located at 
     * the relative path "../../database/Data.db".
     *
     * @return \PDO The PDO instance representing the connection.
     */
    public function connect()
    {
        // Create a new PDO instance to connect to the SQLite database
        return new \PDO("sqlite:" . __DIR__ . "/../../database/Data.db");
    }
}