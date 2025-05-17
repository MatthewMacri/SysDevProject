<?php

namespace App\Models;

use PDO;

class Supplier
{
    private $db;

    // Constructor to initialize the database connection
    public function __construct()
    {

    }

    /**
     * Update a supplier's information in the database.
     * 
     * @param int $id Supplier ID to update
     * @param array $data Associative array of updated data for the supplier
     * @return bool Returns true if the update was successful, false otherwise
     */
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE supplier
            SET supplier_name = ?, company_name = ?, email = ?, supplier_phone_number = ?
            WHERE supplier_id = ?
        ");
        return $stmt->execute([
            $data['supplier_name'],
            $data['company_name'],
            $data['supplier_email'],
            $data['supplier_phone_number'],
            $id
        ]);
    }

    /**
     * Delete a supplier from the database by its ID.
     * 
     * @param int $id Supplier ID to delete
     * @return bool Returns true if the deletion was successful, false otherwise
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM supplier WHERE supplier_id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Fetch all suppliers from the database.
     * 
     * @return array An array of all suppliers as associative arrays
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM supplier");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Fetch a specific supplier from the database by its ID.
     * 
     * @param int $id Supplier ID to retrieve
     * @return array|null An associative array of the supplier's data, or null if not found
     */
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM supplier WHERE supplier_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new supplier in the database.
     * 
     * @param array $data Associative array of data for the new supplier
     * @return bool Returns true if the creation was successful, false otherwise
     */
    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO supplier (supplier_name, company_name, email, supplier_phone_number)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['supplier_name'],
            $data['company_name'],
            $data['supplier_email'],
            $data['supplier_phone_number']
        ]);
    }

    public function findOrCreate(array $supplier): int
    {
        $stmt = $this->db->prepare("SELECT supplier_id FROM Supplier WHERE supplier_name = ? AND email = ?");
        $stmt->execute([$supplier['name'], $supplier['email']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing)
            return $existing['supplier_id'];

        $stmt = $this->db->prepare("INSERT INTO Supplier (supplier_name, company_name, email, supplier_phone_number)
                                VALUES (?, ?, ?, ?)");
        $stmt->execute([$supplier['name'], $supplier['company'], $supplier['email'], $supplier['phone']]);

        return $this->db->lastInsertId();
    }

    public function linkToProject(int $supplierId, int $projectId, ?string $supplierStartDate): void
    {
        $stmt = $this->db->prepare("INSERT INTO `Supplier-Project` 
        (supplier_id, project_id, supplier_start_date)
        VALUES (?, ?, ?)"
        );
        $stmt->execute([$supplierId, $projectId, $supplierStartDate]);
    }
}