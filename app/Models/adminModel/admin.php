<?php

namespace App\Models;

class Admin {
    private $db;
    private ?int $adminId;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $email;
    private ?string $password;

    public function __construct(?int $adminId, string $firstName, string $lastName, string $email, string $password, $db)
    {
        $this->db = $db;
        $this->adminId = $adminId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
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
        return $stmt->execute([$data['admin_name'], $data['first_name'], $data['last_name'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);
    }

    public function getAdminId(): ?int {
        return $this->adminId;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setAdminId(?int $adminId): void {
        $this->adminId = $adminId;
    }

    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }
}