<?php

namespace App\Models;

class Admin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllAdmins() {
        $stmt = $this->db->query("SELECT * FROM admin");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAdminById($id) {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE admin_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addAdmin($data) {
        $stmt = $this->db->prepare("INSERT INTO admin (admin_name, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['admin_name'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT)
        ]);
    }

    public function updateAdmin($id, $data) {
        $stmt = $this->db->prepare("UPDATE admin SET admin_name = ?, first_name = ?, last_name = ?, email = ?, password = ? WHERE admin_id = ?");
        return $stmt->execute([
            $data['admin_name'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $id
        ]);
    }

    public function deleteAdmin($id) {
        $stmt = $this->db->prepare("DELETE FROM admin WHERE admin_id = ?");
        return $stmt->execute([$id]);
    }
}