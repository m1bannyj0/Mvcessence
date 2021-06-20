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
        // If he's not we redirect to the registration page and die()
        if ($this->action === "edit") {
            echo "Here we'll be editing";
        } else {
            echo "Here will be the profile";
        }
    }

    private function processPostRequest()
    {

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