<?php
namespace EssenceList\Controllers;

use EssenceList\AuthManager;
use EssenceList\Entities\Essence;
use EssenceList\Database\EssenceDataGateway;
use EssenceList\Validators\EssenceValidator;
use EssenceList\Helpers\Util;


class RegisterController extends BaseController
{
    private $gateway;
    private $validator;
    private $util;
    private $authManager;

    public function __construct(string $requestType,
                                EssenceDataGateway $gateway,
                                EssenceValidator $validator,
                                Util $util,
                                AuthManager $authManager)
    {
        $this->requestType = $requestType;
        $this->gateway = $gateway;
        $this->validator = $validator;
        $this->util = $util;
        $this->authManager = $authManager;
    }

    private function processGetRequest()
    {
        $this->render(__DIR__."/../../views/register.view.php");
    }

    private function processPostRequest()
    {
        $values = $this->grabPostValues();
        $essence = $this->createEssence($values);
        $errors = $this->validator->validateAllFields($essence);

        if (empty($errors)) {
            $hash = $this->util->generateHash();
            $essence->setHash($hash);
            $this->gateway->insertEssence($essence);
            $this->authManager->logIn($hash);
            echo "Успех!";
        } else {
            // Re-render the form passing $errors and $values arrays
            $params["values"] = $values;
            $params["errors"] = $errors;
            $this->render(__DIR__ . "/../../views/register.view.php", $params);
        }

    }

    private function createEssence(array $values)
    {
        $essence = new Essence(
            $values["name"],
            $values["surname"],
            $values["group_number"],
            $values["email"],
            $values["exam_score"],
            $values["birth_year"],
            $values["gender"],
            $values["residence"]
        );

        return $essence;
    }

    private function grabPostValues()
    {
        $values = [];

        $values["name"] = array_key_exists("name", $_POST) ?
            strval(trim($_POST["name"])) :
            "";
        $values["surname"] = array_key_exists("surname", $_POST) ?
            strval(trim($_POST["surname"])) :
            "";
        $values["birth_year"] = array_key_exists("birth_year", $_POST) ?
            intval($_POST["birth_year"]) :
            0;
        $values["gender"] = array_key_exists("gender", $_POST) ?
            strval($_POST["gender"]) :
            "";
        $values["group_number"] = array_key_exists("group_number", $_POST) ?
            strval(trim($_POST["group_number"])) :
            "";
        $values["exam_score"] = array_key_exists("exam_score", $_POST) ?
            intval($_POST["exam_score"]) :
            0;
        $values["email"] = array_key_exists("email", $_POST) ?
            strval(trim($_POST["email"])) :
            "";
        $values["residence"] = array_key_exists("residence", $_POST) ?
            strval($_POST["residence"]) :
            "";

        return $values;
    }

    private function render($file, $params = [])
    {
        extract($params, EXTR_SKIP);
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

