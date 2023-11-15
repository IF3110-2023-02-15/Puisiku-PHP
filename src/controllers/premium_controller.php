<?php

require_once 'controller.php';
require_once SERVICES_DIR . 'external/rest/index.php';
require_once SERVICES_DIR . 'external/soap/index.php';

class Premium extends Controller {
    public function index() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->loadView();
                break;
            case 'POST':
                $this->subscribe();
                break;
            default:
                $this->methodNotAllowed();
        }
    }

    private function loadView() {
        $restService = new RestService();

        try {
            $current_page = 'Premium';
            $display_search = false;

            list($role, $profile_url, $playlists) = $this->getSidebarNavbarInfo();

            // Get creators from REST
            $creators = json_decode($restService->call('GET', '/user/creators'));

            $subscribedCreatorsId = $this->getSubscribedCreators();

            $subscribedCreators = array();
            foreach($creators as $key => $creator) {
                if (in_array($creator->id, $subscribedCreatorsId)) {
                    $subscribedCreators[] = $creator;
                    unset($creators[$key]);
                }
            }

            $this->view('premium/index', ['current_page' => $current_page, 'playlists'=> $playlists, 'role' => $role, 'display_search' => $display_search, 'profile_url' => $profile_url, 'creators' => $creators, 'subscribedCreators' => $subscribedCreators]);
        } catch (Exception $e) {
            $this->notFound();
        }
    }

    private function subscribe() {
        $creatorId = isset($_POST['creatorId']) ? $_POST['creatorId'] : null;

        $soapService = new SOAPService("/subscription");
        $email = $_SESSION['email'];

        try {
            $subscribe = $soapService->call('subscribe', ['email' => $email, 'creatorId' => $creatorId]);
            $status = $subscribe->return->status;
            $message = $subscribe->return->message;

            if ($status == 200) {
                unset($_SESSION['subscribedCreators']);
                echo json_encode(['success' => $message]);
            } else {
                throw new Exception('Error subscribing to creator');
            }
        } catch (Exception $e) {
            echo json_encode(['error' => $e]);
        }
    }
}
