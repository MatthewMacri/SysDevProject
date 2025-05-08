<?php

namespace App\Models;
use PDO;

class client
{
    //ORM in Laravel may require ID
    private $clientID;
    private $clientName;
    private $companyName;
    private $clientEmail;
    private $clientPhoneNumber;

    /**
     * @param $clientID
     * @param $clientName
     * @param $companyName
     * @param $clientEmail
     * @param $clientPhoneNumber
     */
    public function __construct($clientName, $companyName, $clientEmail, $clientPhoneNumber)
    {
        //Let DB auto assign ID (insert method in controller returns ID from DB
        $this->clientName = $clientName;
        $this->companyName = $companyName;
        $this->clientEmail = $clientEmail;
        $this->clientPhoneNumber = $clientPhoneNumber;
    }

    /**
     * @return mixed
     */
    public function getClientID()
    {
        return $this->clientID;
    }

    /**
     * @param mixed $clientID
     */
    public function setClientID($clientID)
    {
        $this->clientID = $clientID;
    }

    /**
     * @return mixed
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param mixed $clientName
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param mixed $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return mixed
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @param mixed $clientEmail
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;
    }

    /**
     * @return mixed
     */
    public function getClientPhoneNumber()
    {
        return $this->clientPhoneNumber;
    }

    /**
     * @param mixed $clientPhoneNumber
     */
    public function setClientPhoneNumber($clientPhoneNumber)
    {
        $this->clientPhoneNumber = $clientPhoneNumber;
    }
    
    public function create(PDO $pdo): bool
{
    $stmt = $pdo->prepare("
        INSERT INTO clients (clientName, companyName, clientEmail, clientPhoneNumber)
        VALUES (:clientName, :companyName, :clientEmail, :clientPhoneNumber)
    ");

    if ($stmt->execute([
        ':clientName' => $this->clientName,
        ':companyName' => $this->companyName,
        ':clientEmail' => $this->clientEmail,
        ':clientPhoneNumber' => $this->clientPhoneNumber
    ])) {
        $this->clientID = (int)$pdo->lastInsertId();
        return true;
    }
    return false;
}

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

public function delete(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("DELETE FROM clients WHERE clientID = :id");
    return $stmt->execute([':id' => $id]);
}

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