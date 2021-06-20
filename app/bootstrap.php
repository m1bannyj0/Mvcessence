<?php
use EssenceList\App;
use EssenceList\Database\{Connection, EssenceDataGateway};

$app = new App();

$app->bind("config", require_once "../config.php");
$app->bind("connection", (new Connection)->make($app->get("config")));
$app->bind("essenceDataGateway", new EssenceDataGateway($app->get("connection")));


