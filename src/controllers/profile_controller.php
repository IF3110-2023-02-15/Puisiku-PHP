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
            case 'PUT':
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

        $data = $this->getData();

        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $username = isset($data['username']) ? $data['username'] : null;
        $description = isset($data['description']) ? $data['description'] : null;
        $imagePath = isset($data['profile-image-path']) ? $data['profile-image-path'] : null;

        if ($id == null) {
            echo json_encode(['error' => 'Unauthorized']);
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
