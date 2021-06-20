<?php
namespace EssenceList\Controllers;

use EssenceList\App;

class ControllerFactory
{
    public static function makeController(string $controllerName,
                                          string $requestType,
                                          App $DIContainer)
    {
        $controller = null;

        switch ($controllerName)
        {
            case "HomeController":
                $controller = new HomeController($requestType);
                break;
            case "RegisterController":
                $controller = new RegisterController(
                    $requestType,
                    $DIContainer->get("essenceDataGateway"),
                    $DIContainer->get("essenceValidator")
                );
                break;
        }

        return $controller;
    }
}
