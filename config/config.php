<?php
define('APP_NAME', 'Fitness Tracker');
define('APP_VERSION', '1.0.0');
define('ENVIRONMENT', 'development');
define('BASE_URL', 'http://localhost/fitness-tracker');
define('ASSETS_URL', BASE_URL . '/public');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('ROOT_PATH', dirname(dirname(__FILE__)));
define('APP_PATH', ROOT_PATH . '/app');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VIEWS_PATH', APP_PATH . '/views');
define('EXPORT_PATH', ROOT_PATH . '/exports');
define('ROLE_ADMIN', 'admin');
define('ROLE_USER', 'user');
define('ITEMS_PER_PAGE', 10);
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
date_default_timezone_set('Europe/Belgrade');
if (session_status() === PHP_SESSION_NONE) {
    session_name('fitness_tracker_session');
    session_start();
}
