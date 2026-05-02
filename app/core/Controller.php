<?php
class Controller
{
    protected $data = [];
    protected function model($model)
    {
        $modelFile = APP_PATH . '/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        throw new Exception("Model $model not found");
    }
    protected function view($view, $data = [])
    {
        extract($data);
        $viewFile = VIEWS_PATH . '/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new Exception("View $view not found");
        }
    }
    protected function render($view, $data = [], $layout = 'layouts/main')
    {
        $this->data = $data;
        extract($data);
        ob_start();
        $this->view($view, $data);
        $content = ob_get_clean();
        $layoutFile = VIEWS_PATH . '/' . str_replace('.', '/', $layout) . '.php';
        if (file_exists($layoutFile)) {
            require_once $layoutFile;
        } else {
            throw new Exception("Layout $layout not found");
        }
    }
    protected function redirect($url)
    {
        if (strpos($url, 'http') !== 0) {
            $url = BASE_URL . '/' . ltrim($url, '/');
        }
        header("Location: $url");
        exit;
    }
    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }
    protected function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === ROLE_ADMIN;
    }
    protected function requireLogin()
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['flash_message'] = 'Morate biti ulogovani za pristup ovoj stranici';
            $_SESSION['flash_type'] = 'warning';
            $this->redirect('/login');
        }
    }
    protected function requireAdmin()
    {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            $_SESSION['flash_message'] = 'Nemate ovlascenja za pristup ovoj stranici, ';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/');
        }
    }
    protected function setFlash($message, $type = 'info')
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    protected function getFlash()
    {
        if (isset($_SESSION['flash_message'])) {
            $flash = [
                'message' => $_SESSION['flash_message'],
                'type' => $_SESSION['flash_type'] ?? 'info'
            ];
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
            return $flash;
        }
        return null;
    }
    protected function json($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
    protected function notFound()
    {
        http_response_code(404);
        $this->render('errors/404');
        exit;
    }
    protected function validateCSRF()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $this->setFlash('Neispravna sesija. Prokusajte ponovo.', 'danger');
                $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
            }
        }
    }
    protected function generateCSRF()
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }
}
