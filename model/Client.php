<?php

namespace App\Models;

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

}