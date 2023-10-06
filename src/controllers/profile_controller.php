<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'user/index.php';
require_once SERVICES_DIR . 'file/index.php';

class Profile extends Controller {
    public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            case 'POST':
                $this->updateProfile();
                break;
            default:
                $this->methodNotAllowed();
                break;
        }
    }

    private function loadView() {
        $id=isset($_SESSION['id'])?($_SESSION['id']):null;
        $userService=new UserService();
        $data= $userService->getData($id);
        $this->view('profile/index', ['data'=>$data]);
    }

    private function updateProfile() {
        header('Content-Type: application/json');

        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        $image = isset($_FILES['profile-image-path']['tmp_name']) ? $_FILES['profile-image-path']['tmp_name'] : null;

        if ($id == null) {
            echo json_encode(['error' => 'Unauthorized']);
        }

        $imagePath = null;

        // Try to upload file
        if ($image != null) {
            $fileService = new FileService();

            try {
                $imagePath = $fileService->upload($_FILES['profile-image-path']);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
                return;
            }
        }

        $userService = new UserService();
        try {
            $result = $userService->update($id, $username, $description, $imagePath);
            echo json_encode(['success' => 'User updated successfully', 'result' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Error updating user: ' . $e->getMessage()]);
        }
    }

    public function upgrade() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->methodNotAllowed();
            return;
        }

        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

        $userService = new UserService();

        try {
            $result = $userService->updateRole($id);

            $_SESSION['role'] = 'creator';

            echo json_encode(['success' => $result]);
        } catch (Exception $e) {
            echo json_encode(['error' => $e]);
        }
    }
}
