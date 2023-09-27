<?php

require_once 'controller.php';

/**
 * @class File
 * @brief Handles file uploads.
 *
 * This class extends the Controller class and is designed to handle file uploads.
 * It supports uploading of image and audio files. The uploaded files are saved in
 * the /var/www/html/public/img/ directory for images and /var/www/html/public/audio/
 * directory for audio files within the Docker container.
 *
 * To use this class, create an HTML form with enctype="multipart/form-data"
 * for each type of file that is wanted to be uploaded.
 *
 * Here's an example of how to create forms for image and audio file uploads:
 *
 * @code{.html}
 * <!-- Form for audio upload -->
 * <form action="/upload" method="post" enctype="multipart/form-data">
 *     Select audio to upload:
 *     <input type="file" name="fileToUpload" id="fileToUpload" accept=".mp3">
 *     <input type="submit" value="Upload Audio" name="submit">
 * </form>
 *
 * <!-- Form for image upload -->
 * <form action="/upload" method="post" enctype="multipart/form-data">
 *     Select image to upload:
 *     <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png">
 *     <input type="submit" value="Upload Image" name="submit">
 * </form>
 * @endcode
 */
class File extends Controller {
    public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->upload();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    /*
     * TODO: will integrate this with AJAX for success message
     */
    private function upload() {
        // Check if a file was uploaded
        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $_FILES['fileToUpload']['tmp_name'];
            $fileName = time() . '_' . $_FILES['fileToUpload']['name']; // Prepend the current timestamp to the filename
            $fileType = $_FILES['fileToUpload']['type'];

            // Define the destination path within the container based on file type
            if (strpos($fileType, 'image') !== false) {
                $destination = '/var/www/html/public/img/' . $fileName;
            } elseif (strpos($fileType, 'audio') !== false) {
                $destination = '/var/www/html/public/audio/' . $fileName;
            } else {
                echo "Unsupported file type!";
                return;
            }

            // Move the uploaded file to the destination
            if(move_uploaded_file($uploadedFile, $destination)) {
                echo "File uploaded successfully!";
            } else {
                echo "File upload failed!";
            }
        } else {
            echo "No file uploaded or an error occurred during upload.";
        }
    }
}
