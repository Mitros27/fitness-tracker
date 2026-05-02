<?php
class App
{
     private static $instance = null;
     private $router;
     private function __construct()
     {
          $this->router = new Router();
     }
     public static function getInstance()
     {
          if (self::$instance === null) {
               self::$instance = new App();
          }
          return self::$instance;
     }
     public function run()
     {
          $this->loadRoutes();
          $url = $_SERVER['REQUEST_URI'] ?? '/';
          $this->router->dispatch($url);
     }
     public function loadRoutes()
     {
          $routesFile = CONFIG_PATH . '/routes.php';
          if (file_exists($routesFile)) {
               $router = $this->router;
               require $routesFile;
          }
     }
     public function getRouter()
     {
          return $this->router;
     }
}
