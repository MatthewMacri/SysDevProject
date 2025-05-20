<?php

namespace App\Http\Controllers\mediaControllers;

require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
$app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';

require_once app_path('Models/mediaModels/video.php');

use App\Models\mediaModels\Video;
class VideoController {
    private $model;

    /**
     * Constructor that initializes the Video model.
     * 
     * @param object $db Database connection instance
     */
    public function __construct($db) {
        // Instantiate the Video model with the database connection
        $this->model = new Video($db);
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
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/viewVideos.php');
    }

    /**
     * Shows the form for uploading a new video.
     * 
     * @return void
     */
    public function uploadForm() {
        // Include the video upload form view
        if (!function_exists('resource_path')) {
            require_once dirname(__DIR__, 4) . '/vendor/autoload.php';
            $app = require_once dirname(__DIR__, 4) . '/bootstrap/app.php';
        }
        include resource_path('views/uploadVideo.php');
    }

    /**
     * Handles the upload of a new video.
     * 
     * @param array $postData Data from the form submission containing video details
     * 
     * @return void
     */
    public function upload($postData) {

    // Check if the Project ID exists using DatabaseController's runQuery method
        $query = "SELECT * FROM Project WHERE serial_number = :serial_number";
        $params = ['serial_number' => $postData['project_id']];
        
        $result = $this->model->getDb()->runQuery($query, $params);

        if (empty($result)) {
            return;
        }


        // Set the video properties from the submitted form data
        $this->model->setProjectId($postData['project_id']);
        $this->model->setVideoUrl($postData['video_url']);
        $this->model->setFormat($postData['format']);
        $this->model->setDuration($postData['duration']);
        $this->model->setUploadTime(date("Y-m-d H:i:s"));

        // Save the video to the database
        $this->model->save();

    
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
        header('Location: /SysDevProject/video/index');
        exit;
    }
}