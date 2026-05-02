<?php

/**
 * Router Class
 * Rutiranje URL zahteva na odgovarajuce kontrolere
 */

class Router
{
    private $routes = [];
    private $params = [];

    // Dodaj rutu
    public function add($route, $params = [])
    {
        // Konvertuj rutu u regularni izraz
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[^\/]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    // Uzmi sve rute
    public function getRoutes()
    {
        return $this->routes;
    }

    // Match URL sa rutama
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    // Dispatch zahtev
    public function dispatch($url)
    {
        // Ukloni query string
        $url = parse_url($url, PHP_URL_PATH);

        // Ukloni base path
        $basePath = str_replace('http://localhost', '', BASE_URL);
        $url = str_replace($basePath, '', $url);
        $url = ltrim($url, '/');

        // Ako je prazno, postavi na home
        if (empty($url)) {
            $url = 'home/index';
        }

        // Parametri za pozivanje akcije
        $actionParams = [];

        // Pokusaj match sa definisanim rutama
        if ($this->match($url)) {
            $controller = $this->params['controller'] ?? null;
            $action = $this->params['action'] ?? 'index';

            // Izvuci dodatne parametre (id, slug, itd)
            $actionParams = array_filter($this->params, function ($key) {
                return !in_array($key, ['controller', 'action']);
            }, ARRAY_FILTER_USE_KEY);

            // Konvertuj u indeksirani array za call_user_func_array
            $actionParams = array_values($actionParams);
        } else {
            // Default routing: controller/action/params
            $parts = explode('/', $url);
            $controller = ucfirst($parts[0] ?? 'Home');
            $action = $parts[1] ?? 'index';

            // Ostatak su parametri
            $actionParams = array_slice($parts, 2);
        }

        // Dodaj Controller suffix
        $controllerName = $controller;
        if (strpos($controller, 'Controller') === false) {
            $controllerName = $controller . 'Controller';
        }

        // Proveri da li kontroler postoji
        $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;

            // Kreiraj instancu kontrolera
            if (class_exists($controllerName)) {
                $controllerInstance = new $controllerName();

                // Proveri da li metoda postoji
                if (method_exists($controllerInstance, $action)) {
                    // Pozovi akciju sa parametrima
                    call_user_func_array([$controllerInstance, $action], $actionParams);
                } else {
                    $this->error404("Method $action not found in controller $controllerName");
                }
            } else {
                $this->error404("Controller class $controllerName not found");
            }
        } else {
            $this->error404("Controller file not found: $controllerFile");
        }
    }

    // 404 error
    private function error404($message = '')
    {
        header("HTTP/1.0 404 Not Found");

        // Pokusaj ucitati error controller
        $errorController = APP_PATH . '/controllers/ErrorController.php';

        if (file_exists($errorController)) {
            require_once $errorController;
            $controller = new ErrorController();
            $controller->notFound();
        } else {
            echo "<h1>404 - Page Not Found</h1>";
            if (ENVIRONMENT === 'development' && $message) {
                echo "<p>Debug: $message</p>";
            }
            echo "<p><a href='" . BASE_URL . "'>Go to Homepage</a></p>";
        }
        exit;
    }

    // Generisi URL
    public static function url($route, $params = [])
    {
        $url = BASE_URL . '/' . ltrim($route, '/');

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }
}
