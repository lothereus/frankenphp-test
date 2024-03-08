<?php

require '../src/app.php';

$app = new App;

error_log(date('Y-m-d H:i:s') . ' - new app created ' . $app->getAppId());

echo $app->handle(
    $_GET, 
    $_POST, 
    $_COOKIE, 
    $_FILES, 
    $_SERVER
);

$app->terminate();

$app->shutdown();
