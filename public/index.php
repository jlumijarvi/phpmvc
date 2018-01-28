<?php

// enable all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('BASE_PATH', realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));

require BASE_PATH . '/vendor/autoload.php';
require BASE_PATH . '/library/utils.php';

$config = require BASE_PATH . '/config/config.php';
$routes = require BASE_PATH . '/config/routes.php';

$app = App::instance();
$app->setup($config, $routes);
$app->run();
