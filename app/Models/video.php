<?php

namespace App\Models;


require_once (dirname(__DIR__) . '/controller/app/databasecontroller.php');


use Controllers\DatabaseController;



class Video {
    private ?int $videoId;
    private ?int $projectId;
    private ?string $videoUrl;
    private ?string $format;
    private ?int $duration;
    private ?string $uploadTime;

    private DatabaseController $db;

    public function __construct(?int $videoId,?int $projectId,?string $videoUrl,?string $format,?int $duration,?string $uploadTime,DatabaseController $db) 
    {
        $this->videoId = $videoId;
        $this->projectId = $projectId;
        $this->videoUrl = $videoUrl;
        $this->format = $format;
        $this->duration = $duration;
        $this->uploadTime = $uploadTime;
        $this->db = $db;
    }

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

    public function update() {

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
        }
    }

    public function delete() {

        try {
            $sql = "DELETE FROM video WHERE video_id = :video_id";
            $this->db->runQuery($sql, ['video_id' => $this->videoId]);
        } catch (\PDOException $e) {
            echo "Error deleting video: " . $e->getMessage();
        }
    }

    public function findByProjectId(int $projectId): array {
        try {
            $sql = "SELECT * FROM video WHERE project_id = :project_id";
            $result = $this->db->runQuery($sql, ['project_id' => $projectId]);
    
            $videos = [];
    
            foreach ($result as $row) {
                $videos[] = new Video(
                    $row['video_id'],
                    $row['project_id'],
                    $row['video_url'],
                    $row['format'],
                    $row['duration'],
                    $row['upload_time'],
                    $this->db
                );
            }
    
            return $videos;
        } catch (\PDOException $e) {
            echo "Error fetching videos: " . $e->getMessage();
            return [];
        }
    }
}