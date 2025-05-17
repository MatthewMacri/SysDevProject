<?php

namespace App\Http\Controllers\mediaControllers;

require_once 'app/Models/mediaModels/video.php';

class VideoController {
    private $model;

    /**
     * Constructor that initializes the Video model.
     * 
     * @param object $db Database connection instance
     */
    public function __construct($db) {
        // Instantiate the Video model with the database connection
        $this->model = new \App\Models\Video($db);
    }

    /**
     * Displays all videos in the gallery.
     * 
     * Fetches all videos from the model and loads the view.
     * 
     * @return void
     */
    public function index() {
        // Fetch all videos
        $videos = $this->model->getAll();

        // Include the view to display the videos
        include 'resources/views/viewVideos.php';
    }

    /**
     * Shows the form for uploading a new video.
     * 
     * @return void
     */
    public function uploadForm() {
        // Include the video upload form view
        include 'resources/views/uploadVideo.php';
    }

    /**
     * Handles the upload of a new video.
     * 
     * @param array $postData Data from the form submission containing video details
     * 
     * @return void
     */
    public function upload($postData) {
        // Set the video properties from the submitted form data
        $this->model->setProjectId($postData['project_id']);
        $this->model->setVideoUrl($postData['video_url']);
        $this->model->setFormat($postData['format']);
        $this->model->setDuration($postData['duration']);
        $this->model->setUploadTime(date("Y-m-d H:i:s"));

        // Save the video to the database
        $this->model->save();

        // Redirect to the video index page after upload
        header('Location: ?controller=video&action=index');
    }

    /**
     * Deletes a video from the database.
     * 
     * @return void
     */
    public function delete() {
        // Check if the 'id' parameter is present in the URL
        if (isset($_GET['id'])) {
            // Set the video ID to delete
            $this->model->setVideoId($_GET['id']);

            // Delete the video from the database
            $this->model->delete();
        }

        // Redirect to the video index page after deletion
        header('Location: ?controller=video&action=index');
        exit;
    }
}