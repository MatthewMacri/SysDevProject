<?php

namespace App\Models;

class Supplier {
    private ?int $supplierId;
    private ?string $companyName;
    private ?string $email;
    private ?string $supplierPhoneNumber;

    public function __construct(?int $supplierId, ?string $companyName, ?string $email, ?string $supplierPhoneNumber)
    {
        $this->supplierId = $supplierId;
        $this->companyName = $companyName;
        $this->email = $email;
        $this->supplierPhoneNumber = $supplierPhoneNumber;
    }

    public function getSupplierId(): ?int {
        return $this->supplierId;
    }

    public function getCompanyName(): ?string {
        return $this->companyName;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function getSupplierPhoneNumber(): ?string {
        return $this->supplierPhoneNumber;
    }

    public function setSupplierId(?int $supplierId): void {
        $this->supplierId = $supplierId;
    }

    public function setCompanyName(?string $companyName): void {
        $this->companyName = $companyName;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    public function setSupplierPhoneNumber(?string $supplierPhoneNumber): void {
        $this->supplierPhoneNumber = $supplierPhoneNumber;
    }
}