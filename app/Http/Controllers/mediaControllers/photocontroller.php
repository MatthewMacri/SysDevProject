<?php

namespace Controllers;

require_once 'app/Models/mediaModel/photo.php';
use App\Models\Photo;

class PhotoController {
    private $model;

    /**
     * Constructor that initializes the Photo model.
     * 
     * @param object $db Database connection instance
     */
    public function __construct($db) {
        $this->model = new Photo($db);
    }

    /**
     * Displays all photos in the gallery.
     * 
     * Fetches all photos from the model and loads the view.
     * 
     * @return void
     */
    public function index() {
        // Fetch all photos
        $photos = $this->model->getAll();

        // Include the view to display the photos
        include 'resources/views/photo/viewPhoto.php';
    }

    /**
     * Shows the form for uploading a photo.
     * 
     * @return void
     */
    public function uploadForm() {
        // Include the photo upload form view
        include 'resources/views/photo/uploadPhoto.php';
    }

    /**
     * Handles the upload of a new photo.
     * 
     * @param array $postData Data from the form submission containing photo details
     * 
     * @return void
     */
    public function upload($postData) {
        // Prepare data to insert into the database
        $this->model->upload([
            'project_id' => $postData['project_id'],
            'photo_url' => $postData['photo_url'],
            'format' => $postData['format'],
            'upload_time' => date("Y-m-d H:i:s"),
            'caption' => $postData['caption']
        ]);

        // Redirect to the photo index page after upload
        header('Location: ?controller=photo&action=index');
    }

    /**
     * Displays the form for editing an existing photo.
     * 
     * @param int $id The ID of the photo to edit
     * 
     * @return void
     */
    public function edit($id) {
        // Fetch the photo to edit using its ID
        $photo = $this->model->getById($id);

        // Include the photo edit form view
        include 'resources/views/photo/editPhoto.php';
    }

    /**
     * Updates the photo details in the database.
     * 
     * @param int $id The ID of the photo to update
     * @param array $postData Data from the form submission
     * 
     * @return void
     */
    public function update($id, $postData) {
        // Update the photo record in the database
        $this->model->update($id, $postData);

        // Redirect to the photo index page after update
        header('Location: ?controller=photo&action=index');
    }

    /**
     * Deletes a photo from the database.
     * 
     * @param int $id The ID of the photo to delete
     * 
     * @return void
     */
    public function delete($id) {
        // Delete the photo from the database
        $this->model->delete($id);

        // Redirect to the photo index page after deletion
        header('Location: ?controller=photo&action=index');
    }
}