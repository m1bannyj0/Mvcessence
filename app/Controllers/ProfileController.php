<?php
namespace EssenceList\Controllers;

use EssenceList\AuthManager;
use EssenceList\Database\EssenceDataGateway;

class ProfileController extends BaseController
{
    private $essenceDataGateway;
    private $authManager;

    public function __construct(string $requestType,
                                string $action,
                                EssenceDataGateway $essenceDataGateway,
                                AuthManager $authManager)
    {
        $this->requestType = $requestType;
        $this->action = $action;
        $this->essenceDataGateway = $essenceDataGateway;
        $this->authManager = $authManager;
    }

    private function processGetRequest()
    {
        // Check if user is logged in first
        if (!$this->authManager->checkIfIsAuthorized()) {
            // If he's not we redirect to the registration page
            header("Location: /register");
            die();
        }

        // Fetching essence data from the database and preparing it for passing into view
        $essenceData = $this->essenceDataGateway->getEssenceByHash($_COOKIE["hash"]);
        $params["values"] = $essenceData;

        if ($this->action === "edit") {
            $this->render(__DIR__."/../../views/register.view.php", $params);
        } else {
            $this->render(__DIR__."/../../views/profile.view.php", $params);
        }
    }

    private function processPostRequest()
    {
        
    }

    private function render($file, $params = [])
    {
        extract($params,EXTR_SKIP);
        return require_once "{$file}";
    }

    public function run()
    {
        if ($this->requestType === "GET") {
            $this->processGetRequest();
        } else {
            $this->processPostRequest();
        }
    }
}