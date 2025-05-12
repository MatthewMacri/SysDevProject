<?php
namespace Models;

use PDO;

class Client {
    private PDO $db;

    public function __construct() {
        $this->db = new \PDO("sqlite:" . $_SERVER['DOCUMENT_ROOT'] . "/SysDevProject/database/Data.db");
    }

    public function findOrCreate(array $client): int {
        $stmt = $this->db->prepare("SELECT client_id FROM Client WHERE client_name = ? AND email = ?");
        $stmt->execute([$client['name'], $client['email']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) return $existing['client_id'];

        $stmt = $this->db->prepare("INSERT INTO Client (client_name, company_name, email, client_phone_number)
                                    VALUES (?, ?, ?, ?)");
        $stmt->execute([$client['name'], $client['company'], $client['email'], $client['phone']]);

        return $this->db->lastInsertId();
    }
}