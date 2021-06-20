<?php
namespace EssenceList\Controllers;

use EssenceList\App;

class ControllerFactory
{
    public static function makeController(string $controllerName,
                                          string $requestType,
                                          string $action,
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
                    $DIContainer->get("essenceValidator"),
                    $DIContainer->get("util"),
                    $DIContainer->get("authManager")
                );
                break;
            case "ProfileController":
                $controller = new ProfileController(
                    $requestType,
                    $action,
                    $DIContainer->get("EssenceDataGateway"),
                    $DIContainer->get("authManager")
                );
                break;
        }

        return $controller;
    }
}
