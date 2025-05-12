<?php

namespace App\Models;

use PDO;

class Client
{
    // Class properties
    private $clientID;               // Client's unique ID
    private $clientName;             // Name of the client
    private $companyName;            // Name of the company the client represents
    private $clientEmail;            // Client's email address
    private $clientPhoneNumber;      // Client's phone number

    /**
     * Constructor to initialize the Client object with required fields.
     * 
     * @param string $clientName         Client's name
     * @param string $companyName        Name of the company
     * @param string $clientEmail        Client's email address
     * @param string $clientPhoneNumber  Client's phone number
     */
    public function __construct($clientName, $companyName, $clientEmail, $clientPhoneNumber)
    {
        $this->clientName = $clientName;
        $this->companyName = $companyName;
        $this->clientEmail = $clientEmail;
        $this->clientPhoneNumber = $clientPhoneNumber;
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
            INSERT INTO clients (clientName, companyName, clientEmail, clientPhoneNumber)
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
            SET clientName = :clientName, companyName = :companyName, 
                clientEmail = :clientEmail, clientPhoneNumber = :clientPhoneNumber
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
}