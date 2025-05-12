<?php

namespace App\Models;

use PDO;
use Controllers\DatabaseController;

class Client
{
    // Class properties
    private $clientID;               // Client's unique ID
    private $clientName;             // Name of the client
    private $companyName;            // Name of the company the client represents
    private $clientEmail;            // Client's email address
    private $clientPhoneNumber;      // Client's phone number
    private PDO $db;

    
    public function __construct(String $clientName, String $companyName, String $clientEmail, String $clientPhoneNumber)
    {
        $this->clientName = $clientName;
        $this->companyName = $companyName;
        $this->cliendEmail = $clientEmail;
        $this->clientPhoneNumber = $clientPhoneNumber;
        $this->db = DatabaseController::getInstance()->getConnection();
    }

    // Getter and setter methods

    public function getClientID()
    {
        return $this->clientID;
    }

    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
    }

    public function getClientName()
    {
        return $this->clientName;
    }

    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;
    }

    public function getClientPhoneNumber()
    {
        return $this->clientPhoneNumber;
    }

    public function setClientPhoneNumber($clientPhoneNumber)
    {
        $this->clientPhoneNumber = $clientPhoneNumber;
    }

    /**
     * Insert a new client into the database.
     * 
     * @param PDO $pdo Database connection
     * @return bool Returns true if insertion is successful
     */
    public function create(PDO $pdo): bool
    {
        $stmt = $pdo->prepare("
            INSERT INTO clients (client_name, company_name, email, client_phone_number)
            VALUES (:clientName, :companyName, :clientEmail, :clientPhoneNumber)
        ");

        // Execute the query and assign the newly inserted ID to the client object
        if ($stmt->execute([
            ':clientName' => $this->clientName,
            ':companyName' => $this->companyName,
            ':clientEmail' => $this->clientEmail,
            ':clientPhoneNumber' => $this->clientPhoneNumber
        ])) {
            $this->clientID = (int)$pdo->lastInsertId();  // Get the last inserted ID
            return true;
        }
        return false;
    }

    /**
     * Update the client's details in the database.
     * 
     * @param PDO $pdo Database connection
     * @param int $id Client ID
     * @return bool Returns true if update is successful
     */
    public function update(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("
            UPDATE clients 
            SET client_name = :clientName, company_name = :companyName, 
                email = :clientEmail, client_phone_number = :clientPhoneNumber
            WHERE clientID = :id
        ");

        return $stmt->execute([
            ':id' => $id,
            ':clientName' => $this->clientName,
            ':companyName' => $this->companyName,
            ':clientEmail' => $this->clientEmail,
            ':clientPhoneNumber' => $this->clientPhoneNumber
        ]);
    }

    /**
     * Delete a client from the database.
     * 
     * @param PDO $pdo Database connection
     * @param int $id Client ID
     * @return bool Returns true if delete is successful
     */
    public function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM clients WHERE clientID = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Fetch a client by their ID.
     * 
     * @param PDO $pdo Database connection
     * @param int $id Client ID
     * @return ?self Returns the client object or null if not found
     */
    public static function selectById(PDO $pdo, int $id): ?self
    {
        $stmt = $pdo->prepare("SELECT * FROM clients WHERE clientID = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $client = new self($data['clientName'], $data['companyName'], $data['clientEmail'], $data['clientPhoneNumber']);
            $client->setClientID($data['clientID']);
            return $client;
        }
        return null;
    }

    /**
     * Fetch all clients from the database.
     * 
     * @param PDO $pdo Database connection
     * @return array Returns an array of client objects
     */
    public static function selectAll(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM clients");
        $clients = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $client = new self($row['clientName'], $row['companyName'], $row['clientEmail'], $row['clientPhoneNumber']);
            $client->setClientID($row['clientID']);
            $clients[] = $client;
        }
        return $clients;
    }

    public function findOrCreate(array $client): int {
        // 1. Try to find existing client by name + email
        $stmt = $this->db->prepare("
            SELECT client_id FROM Client WHERE client_name = ? AND email = ?
        ");
        $stmt->execute([$client['name'], $client['email']]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            return $existing['client_id'];
        }

        // 2. Insert new client if not found
        $stmt = $this->db->prepare("
            INSERT INTO Client (client_name, company_name, email, client_phone_number)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $client['name'],
            $client['company'],
            $client['email'],
            $client['phone'],
        ]);

        return (int) $this->db->lastInsertId();
    }

}