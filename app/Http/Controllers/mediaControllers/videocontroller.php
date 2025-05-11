<?php

namespace Controllers;

require_once 'app/Models/mediaModels/video.php';

class VideoController {
    private $model;

    public function __construct($db) {
        $this->model = new \App\Models\Video($db);
    }

    public function index() {
        $videos = $this->model->getAll();
        include 'resources/views/viewVideos.php';
    }

    public function uploadForm() {
        include 'resources/views/uploadVideo.php';
    }

    public function upload($postData) {
        $this->model->setProjectId($postData['project_id']);
        $this->model->setVideoUrl($postData['video_url']);
        $this->model->setFormat($postData['format']);
        $this->model->setDuration( $postData['duration']);
        $this->model->setUploadTime(date("Y-m-d H:i:s"));
        $this->model->save();

        header('Location: ?controller=video&action=index');
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->model->setVideoId($_GET['id']);
            $this->model->delete();
        }
        header('Location: ?controller=video&action=index');
        exit;
    }
}
