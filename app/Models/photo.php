<?php

namespace App\Models;

class Photo {
    private ?int $photoId;
    private ?string $photoUrl;
    private ?string $format;
    private ?int $timestamp;
    private ?string $caption;

    public function __construct(?int $photoId, ?string $photoUrl, ?string $format, ?int $timestamp, ?string $caption)
    {
        $this->photoId = $photoId;
        $this->photoUrl = $photoUrl;
        $this->format = $format;
        $this->timestamp = $timestamp;
        $this->caption = $caption;
    }

    public function getPhotoId(): ?int {
        return $this->photoId;
    }

    public function getPhotoUrl(): ?string {
        return $this->photoUrl;
    }

    public function getFormat(): ?string {
        return $this->format;
    }

    public function getTimestamp(): ?int {
        return $this->timestamp;
    }

    public function getCaption(): ?string {
        return $this->caption;
    }

    public function setPhotoId(?int $photoId): void {
        $this->photoId = $photoId;
    }

    public function setPhotoUrl(?string $photoUrl): void {
        $this->photoUrl = $photoUrl;
    }

    public function setFormat(?string $format): void {
        $this->format = $format;
    }

    public function setTimestamp(?int $timestamp): void {
        $this->timestamp = $timestamp;
    }

    public function setCaption(?string $caption): void {
        $this->caption = $caption;
    }
}