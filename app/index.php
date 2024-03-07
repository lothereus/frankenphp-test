<?php

ignore_user_abort(true);

require 'app.php';

$app = new App;

error_log(date('Y-m-d H:i:s') . ' - new worker created ' . $app->getAppId());

$handler = static function () use ($app) {
    echo $app->handle(
        $_GET, 
        $_POST, 
        $_COOKIE, 
        $_FILES, 
        $_SERVER
    );
};

$maxRequests = (int) ($_SERVER['MAX_REQUESTS'] ?? 20); // $_SERVER['MAX_REQUESTS'] seems to create an error
error_log(date('Y-m-d H:i:s') . ' - worker ' . $app->getAppId() . ' - max requests is ' . $maxRequests);

for($nbRequests = 0, $running = true; ($nbRequests < $maxRequests) && $running; ++$nbRequests) {
    $running = \frankenphp_handle_request($handler);

    $app->terminate();

    gc_collect_cycles();
}

error_log(date('Y-m-d H:i:s') . ' - shutdowning worker ' . $app->getAppId() . ' - ' . $nbRequests . '/' . $maxRequests);

if ($nbRequests === $maxRequests) {
    error_log(date('Y-m-d H:i:s') . ' - shutdown worker ' . $app->getAppId() . ', reason : max requests reached');
} else {
    error_log(date('Y-m-d H:i:s') . ' - shutdown worker ' . $app->getAppId() . ', reason : probably an error ?');
}

$app->shutdown();
