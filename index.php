<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

require_once ROOT . DS . 'config' . DS . 'config.php';
require_once ROOT . DS . 'config' . DS . 'database.php';
require_once ROOT . DS . 'config' . DS . 'autoloader.php';

require_once APP_PATH . DS . 'core' . DS . 'Model.php';
require_once APP_PATH . DS . 'core' . DS . 'Controller.php';
require_once APP_PATH . DS . 'core' . DS . 'Router.php';
require_once APP_PATH . DS . 'core' . DS . 'App.php';

try {
    $app = App::getInstance();
    $app->run();
} catch (Exception $e) {
    if (ENVIRONMENT === 'development') {
        echo '<h1>Error</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        echo '<h1>Nesto nije u redu</h1>';
        echo '<p>Molimo pokusajte kasnije</p>';
    }
}
