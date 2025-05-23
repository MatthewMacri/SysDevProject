<?php

namespace App\Models\users;

class Admin {
    private \PDO $db;

    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    public function getAllAdmins() {
        $stmt = $this->db->query("SELECT * FROM Admins");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAdminById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Admins WHERE admin_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addAdmin($postData) {
    $stmt = $this->db->prepare("INSERT INTO Admins (admin_name, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $postData['admin_name'],
        $postData['first_name'],
        $postData['last_name'],
        $postData['email'],
        $postData['password'] // This will now be the encrypted password
    ]);
}

    public function updateAdmin($id, $data) {
        $stmt = $this->db->prepare("UPDATE Admins SET admin_name = ?, first_name = ?, last_name = ?, email = ?, password = ? WHERE admin_id = ?");
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
        $stmt = $this->db->prepare("DELETE FROM Admins WHERE admin_id = ?");
        return $stmt->execute([$id]);
    }
}