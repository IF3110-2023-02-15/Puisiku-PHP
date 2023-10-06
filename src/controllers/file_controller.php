<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'file/index.php';

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

    private function upload() {
        header('Content-Type: application/json');

        $image = isset($_FILES['file']) ? $_FILES['file'] : null;

        if ($image != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($image);
                echo json_encode(['success' => $imagePath]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
        }
    }
}
