<?php

require_once 'app/Models/photo.php';

class PhotoController {
    private $model;

    public function __construct($db) {
        $this->model = new \App\Models\Photo($db);
    }

    public function index() {
        $photos = $this->model->getAll();
        include 'resources/views/viewPhotos.php';
    }

    public function uploadForm() {
        include 'resources/views/uploadPhoto.php';
    }

    public function upload($postData) {
        $this->model->upload([
            'project_id' => $postData['project_id'],
            'photo_url' => $postData['photo_url'],
            'format' => $postData['format'],
            'upload_time' => date("Y-m-d H:i:s"),
            'caption' => $postData['caption']
        ]);
        header('Location: ?controller=photo&action=index');
    }
}
