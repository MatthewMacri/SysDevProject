<?php

namespace App\Models;

use PDO;

class Supplier {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM supplier");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM supplier WHERE supplier_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO supplier (supplier_name, company_name, supplier_email, supplier_phone_number)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['supplier_name'],
            $data['company_name'],
            $data['supplier_email'],
            $data['supplier_phone_number']
        ]);
    }
}