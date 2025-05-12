<?php

namespace App\Models;

require_once (dirname(__DIR__, 2) . 'Http/Controllers/core/databasecontroller.php');

use Controllers\DatabaseController;

class Video {
    private ?int $videoId;         // ID of the video
    private ?int $projectId;       // ID of the associated project
    private ?string $videoUrl;     // URL of the video
    private ?string $format;       // Format of the video (e.g., mp4)
    private ?int $duration;        // Duration of the video in seconds
    private ?string $uploadTime;   // Time when the video was uploaded

    private DatabaseController $db; // Database connection

    /**
     * Constructor to initialize the video model with a database connection.
     * 
     * @param DatabaseController $db Database connection instance
     */
    public function __construct(DatabaseController $db) {
        $this->db = $db;
    }

    // Getter and setter methods for the class properties

    public function getVideoId(): ?int {
        return $this->videoId;
    }

    public function setVideoId(?int $videoId): void {
        $this->videoId = $videoId;
    }

    public function getProjectId(): ?int {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId): void {
        $this->projectId = $projectId;
    }

    public function getVideoUrl(): ?string {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): void {
        $this->videoUrl = $videoUrl;
    }

    public function getFormat(): ?string {
        return $this->format;
    }

    public function setFormat(?string $format): void {
        $this->format = $format;
    }

    public function getDuration(): ?int {
        return $this->duration;
    }

    public function setDuration(?int $duration): void {
        $this->duration = $duration;
    }

    public function getUploadTime(): ?string {
        return $this->uploadTime;
    }

    public function setUploadTime(?string $uploadTime): void {
        $this->uploadTime = $uploadTime;
    }

    /**
     * Saves a new video to the database.
     * 
     * @return bool Returns true if the video is saved successfully, otherwise false
     */
    public function save(): bool {
        try {
            return $this->db->insert('video', [
                'project_id' => $this->projectId,
                'video_url' => $this->videoUrl,
                'format' => $this->format,
                'duration' => $this->duration,
                'upload_time' => $this->uploadTime,
            ]);
        } catch (\Exception $e) {
            echo "Error saving video: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Updates an existing video record in the database.
     * 
     * @return bool Returns true if the update is successful, otherwise false
     */
    public function update(): bool {
        try {
            $sql = "UPDATE video SET project_id = :project_id, video_url = :video_url, format = :format, duration = :duration, upload_time = :upload_time WHERE video_id = :video_id";
            return $this->db->runQuery($sql, [
                'project_id' => $this->projectId,
                'video_url' => $this->videoUrl,
                'format' => $this->format,
                'duration' => $this->duration,
                'upload_time' => $this->uploadTime,
                'video_id' => $this->videoId
            ]);
        } catch (\PDOException $e) {
            echo "Error updating video: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Deletes a video from the database.
     * 
     * @return bool Returns true if the deletion is successful, otherwise false
     */
    public function delete(): bool {
        try {
            $sql = "DELETE FROM video WHERE video_id = :video_id";
            return $this->db->runQuery($sql, ['video_id' => $this->videoId]);
        } catch (\PDOException $e) {
            echo "Error deleting video: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Retrieves all video records from the database.
     * 
     * @return array List of all videos
     */
    public function getAll(): array {
        try {
            $sql = "SELECT * FROM video";
            $result = $this->db->runQuery($sql);
    
            $videos = [];
            foreach ($result as $row) {
                $video = new Video($this->db);
                $video->setVideoId($row['video_id']);
                $video->setProjectId($row['project_id']);
                $video->setVideoUrl($row['video_url']);
                $video->setFormat($row['format']);
                $video->setDuration($row['duration']);
                $video->setUploadTime($row['upload_time']);
                $videos[] = $video;
            }
    
            return $videos;
        } catch (\PDOException $e) {
            echo "Error fetching videos: " . $e->getMessage();
            return [];
        }
    }    

    /**
     * Retrieves all videos associated with a specific project ID.
     * 
     * @param int $projectId Project ID
     * @return array List of videos for the given project
     */
    public function findByProjectId(int $projectId): array {
        try {
            $sql = "SELECT * FROM video WHERE project_id = :project_id";
            $result = $this->db->runQuery($sql, ['project_id' => $projectId]);
    
            $videos = [];
            foreach ($result as $row) {
                $video = new Video($this->db);
                $video->setVideoId($row['video_id']);
                $video->setProjectId($row['project_id']);
                $video->setVideoUrl($row['video_url']);
                $video->setFormat($row['format']);
                $video->setDuration($row['duration']);
                $video->setUploadTime($row['upload_time']);
                $videos[] = $video;
            }
    
            return $videos;
        } catch (\PDOException $e) {
            echo "Error fetching videos: " . $e->getMessage();
            return [];
        }
    }
}