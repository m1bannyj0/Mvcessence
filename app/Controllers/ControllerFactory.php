<?php
namespace EssenceList\Controllers;

use EssenceList\App;

class ControllerFactory
{
    public static function makeController(string $controllerName,
                                          string $requestMethod,
                                          string $action,
                                          App $DIContainer)
    {
        $controller = null;

        switch ($controllerName)
        {
            case "HomeController":
                $controller = new HomeController(
                    $requestMethod,
                    $DIContainer->get("pager"),
                    $DIContainer->get("essenceDataGateway")
                );
                break;
            case "RegisterController":
                $controller = new RegisterController(
                    $requestMethod,
                    $DIContainer->get("essenceDataGateway"),
                    $DIContainer->get("essenceValidator"),
                    $DIContainer->get("util"),
                    $DIContainer->get("authManager"),
                    $DIContainer->get("urlManager")
                );
                break;
            case "ProfileController":
                $controller = new ProfileController(
                    $requestMethod,
                    $action,
                    $DIContainer->get("essenceDataGateway"),
                    $DIContainer->get("essenceValidator"),
                    $DIContainer->get("authManager"),
                    $DIContainer->get("util"),
                    $DIContainer->get("urlManager")
                );
                break;
        }

        return $controller;
    }
}
