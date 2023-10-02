<?php

class FileService {
    public function upload($fileToUpload) {
        // Check if a file was uploaded
        if(isset($fileToUpload) && $fileToUpload['error'] === UPLOAD_ERR_OK) {
            $uploadedFile = $fileToUpload['tmp_name'];
            $fileName = time() . '_' . $fileToUpload['name']; // Prepend the current timestamp to the filename
            $fileType = $fileToUpload['type'];

            // Define the destination path within the container based on file type
            if (strpos($fileType, 'image') !== false) {
                $destination = IMAGE_VOLUME . $fileName;
                $pathPrefix = '/img/';
            } elseif (strpos($fileType, 'audio') !== false) {
                $destination = AUDIO_VOLUME . $fileName;
                $pathPrefix = '/audio/';
            } else {
                throw new Exception("Unsupported file type!");
            }

            // Move the uploaded file to the destination
            if(move_uploaded_file($uploadedFile, $destination)) {
                return $pathPrefix . $fileName;
            } else {
                throw new Exception("File upload failed!");
            }
        } else {
            throw new Exception("No file uploaded or an error occurred during upload.");
        }
    }
}


