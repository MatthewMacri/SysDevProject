<?php

namespace App\Models;

use PDO;

class Photo {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM photo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM photo WHERE photo_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE photo SET project_id = ?, photo_url = ?, format = ?, caption = ? WHERE photo_id = ?");
        return $stmt->execute([
            $data['project_id'],
            $data['photo_url'],
            $data['format'],
            $data['caption'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM photo WHERE photo_id = ?");
        return $stmt->execute([$id]);
    }
}