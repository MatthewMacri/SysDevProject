<?php

namespace App\Models;

use PDO;

class Supplier
{
    private $db;

    /**
     * Constructor to initialize the Supplier model with the database connection.
     *
     * @param PDO $db The PDO instance for the database connection.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Retrieves all suppliers from the database.
     *
     * Executes a query to fetch all rows from the 'supplier' table.
     *
     * @return array The list of all suppliers as an associative array.
     */
    public function getAll()
    {
        // Query to fetch all suppliers from the 'supplier' table
        $stmt = $this->db->query("SELECT * FROM supplier");

        // Return all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a supplier by ID from the database.
     *
     * Executes a prepared statement to fetch a single supplier's details
     * based on the supplier's ID.
     *
     * @param int $id The ID of the supplier to fetch.
     * @return array|null The supplier's details as an associative array, or null if not found.
     */
    public function selectByID($id)
    {
        // Prepare a query to fetch a supplier by its ID
        $stmt = $this->db->prepare("SELECT * FROM supplier WHERE supplier_id = ?");
        $stmt->execute([$id]);

        // Fetch and return the supplier data as an associative array, or null if not found
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Creates a new supplier in the database.
     *
     * Inserts a new supplier's data into the 'supplier' table.
     *
     * @param array $data The data of the supplier to be created.
     * @return bool True on success, false on failure.
     */
    public function create($data)
    {
        // Prepare a query to insert a new supplier into the database
        $stmt = $this->db->prepare("
            INSERT INTO supplier (supplier_name, company_name, supplier_email, supplier_phone_number)
            VALUES (?, ?, ?, ?)
        ");

        // Execute the query with the provided data
        return $stmt->execute([
            $data['supplier_name'],
            $data['company_name'],
            $data['supplier_email'],
            $data['supplier_phone_number']
        ]);
    }
}