<?php
namespace Models;

use PDO;

class Supplier {
    private PDO $db;

    public function __construct() {
        $this->db = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/SysDevProject/database/Data.db");
    }

    public function findOrCreate(array $supplier): int {
        $stmt = $this->db->prepare("SELECT supplier_id FROM Supplier WHERE supplier_name = ? AND email = ?");
        $stmt->execute([$supplier['name'], $supplier['email']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) return $existing['supplier_id'];

        $stmt = $this->db->prepare("INSERT INTO Supplier (supplier_name, company_name, email, supplier_phone_number)
                                    VALUES (?, ?, ?, ?)");
        $stmt->execute([$supplier['name'], $supplier['company'], $supplier['email'], $supplier['phone']]);

        return $this->db->lastInsertId();
    }

    public function linkToProject(int $supplierId, int $projectId, ?string $supplierDate = null): void {
        $stmt = $this->db->prepare("INSERT INTO `Supplier-Project` (supplier_id, project_id, supplier_start_date)
                                    VALUES (?, ?, ?)");
        $stmt->execute([$supplierId, $projectId, $supplierDate]);
    }
}