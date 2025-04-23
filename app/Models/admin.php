<?php

namespace App\Models;

class Admin {
    private ?int $adminId;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $email;
    private ?string $password;

    public function __construct(?int $adminId, string $firstName, string $lastName, string $email, string $password)
    {
        $this->adminId = $adminId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
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