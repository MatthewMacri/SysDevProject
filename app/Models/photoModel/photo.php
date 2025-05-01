<?php

namespace App\Models;

require_once 'app/Models/photo.php';

use PDO;

class Photo {
    private ?int $photoId;
    private ?string $photoUrl;
    private ?string $format;
    private ?int $timestamp;
    private ?string $caption;

    private $db;
    private $model;
    public function __construct($db) {
        $this->model = new \App\Models\Photo($db);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM photo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByProject($project_id) {
        $stmt = $this->db->prepare("SELECT * FROM photo WHERE project_id = ?");
        $stmt->execute([$project_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function upload($data) {
        $stmt = $this->db->prepare("INSERT INTO photo (project_id, photo_url, format, upload_time, caption) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['project_id'],
            $data['photo_url'],
            $data['format'],
            $data['upload_time'],
            $data['caption']
        ]);
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