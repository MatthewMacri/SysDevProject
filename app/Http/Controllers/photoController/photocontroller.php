<?php

require_once 'app/Models/photoModel/photo.php';
use App\Models\Photo;

class PhotoController {
    private $model;

    public function __construct($db) {
        $this->model = new Photo($db);
    }

    public function index() {
        $photos = $this->model->getAll();
        include 'resources/views/photo/viewPhoto.php';
    }

    public function uploadForm() {
        include 'resources/views/photo/uploadPhoto.php';
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

    public function edit($id) {
        $photo = $this->model->getById($id);
        include 'resources/views/photo/editPhoto.php';
    }

    public function update($id, $postData) {
        $this->model->update($id, $postData);
        header('Location: ?controller=photo&action=index');
    }

    public function delete($id) {
        $this->model->delete($id);
        header('Location: ?controller=photo&action=index');
    }
}