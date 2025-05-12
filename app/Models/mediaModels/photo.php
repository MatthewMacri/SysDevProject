<?php

namespace App\Models;

use PDO;

class Photo {
    private $db;

    /**
     * Constructor to initialize the database connection.
     * 
     * @param PDO $db Database connection object
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Retrieves all photos from the 'photo' table.
     * 
     * @return array List of all photos
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM photo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves a photo by its ID.
     * 
     * @param int $id Photo ID
     * @return array Photo details
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM photo WHERE photo_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves photos associated with a specific project ID.
     * 
     * @param int $project_id Project ID
     * @return array List of photos for the project
     */
    public function getByProject($project_id) {
        $stmt = $this->db->prepare("SELECT * FROM photo WHERE project_id = ?");
        $stmt->execute([$project_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Uploads a new photo to the database.
     * 
     * @param array $data Data for the new photo, including project_id, photo_url, format, upload_time, and caption
     * @return bool Returns true if the photo was successfully uploaded, false otherwise
     */
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

    /**
     * Updates the details of an existing photo.
     * 
     * @param int $id Photo ID
     * @param array $data Updated data for the photo
     * @return bool Returns true if the photo was successfully updated, false otherwise
     */
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

    /**
     * Deletes a photo from the database.
     * 
     * @param int $id Photo ID
     * @return bool Returns true if the photo was successfully deleted, false otherwise
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM photo WHERE photo_id = ?");
        return $stmt->execute([$id]);
    }
}