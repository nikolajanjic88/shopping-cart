<?php
session_start();

const BASE_PATH = __DIR__ . "/../";

require_once BASE_PATH . 'core/config.php';
require_once BASE_PATH . 'vendor/autoload.php';
require_once BASE_PATH . 'core/functions.php';
require_once BASE_PATH . 'routes/web.php';

$app->run();
