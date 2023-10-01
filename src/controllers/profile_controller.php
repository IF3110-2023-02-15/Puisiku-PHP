<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'user/index.php';

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

        // Check if all required fields are set
        if (!isset($_POST["name"]) || !isset($_POST["description"]) || !isset($_POST["img-profile"])) {
            echo json_encode(['status' => 'ERROR', 'message' => 'Please fill in all the required fields!']);
            exit();
        }

        $name=isset($_POST['name'])?($_POST['name']):null;
        $description=isset($_POST['description'])?($_POST['description']):null;
        $imgProfile=isset($_POST['img-profile'])?($_POST['img-profile']):null;

        echo $name, $description, $imgProfile;  
    }
}
