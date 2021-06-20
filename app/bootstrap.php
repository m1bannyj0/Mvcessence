<?php
use EssenceList\{App, AuthManager};
use EssenceList\Validators\EssenceValidator;
use EssenceList\Helpers\{UrlManager, Util, Pager};
use EssenceList\Database\{Connection, EssenceDataGateway};

$app = new App();

$app->bind("config", require_once "../config.php");
$app->bind("connection", (new Connection)->make($app->get("config")));
$app->bind("authManager", new AuthManager());
$app->bind("essenceDataGateway", new EssenceDataGateway($app->get("connection")));
$app->bind("essenceValidator", new EssenceValidator(
            $app->get("essenceDataGateway"),
                  $app->get("authManager")
            ));
$app->bind("urlManager", new UrlManager());
$app->bind("util", new Util());
$app->bind("pager", new Pager());



