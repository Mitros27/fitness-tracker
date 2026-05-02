<?php
class AuthController extends Controller
{
    public function login()
    {
        // Ako je vec ulogovan, preusmeri ga (admin na /admin, user na /dashboard)
        if ($this->isLoggedIn()) {
            if ($_SESSION['role'] === 'admin') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/dashboard');
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $this->setFlash('Unesite korisnicko ime i lozinku.', 'danger');
                $this->redirect('/login');
            }

            $userModel = $this->model('User');
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                $this->setFlash('Dobrodosli, ' . $user['full_name'] . '!', 'success');

                // Admin ide na admin panel, ostali na dashboard
                if ($user['role'] === 'admin') {
                    $this->redirect('/admin');
                } else {
                    $this->redirect('/dashboard');
                }
            } else {
                $this->setFlash('Pogresno korisnicko ime ili lozinka', 'danger');
                $this->redirect('/login');
            }
        }

        $this->render('auth/login', [
            'title' => 'Prijava'
        ]);
    }

    public function register()
    {
        // Ako je vec ulogovan, preusmeri ga (admin na /admin, user na /dashboard)
        if ($this->isLoggedIn()) {
            if ($_SESSION['role'] === 'admin') {
                $this->redirect('/admin');
            } else {
                $this->redirect('/dashboard');
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $fullName = trim($_POST['full_name'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($email) || empty($fullName) || empty($password)) {
                $this->setFlash('Sva polja su obavezna', 'danger');
                $this->redirect('/register');
            }

            if ($password !== $confirmPassword) {
                $this->setFlash('Lozinke se ne poklapaju', 'danger');
                $this->redirect('/register');
            }

            $userModel = $this->model('User');

            if ($userModel->findByUsername($username)) {
                $this->setFlash('Korisnicko ime je vec zauzeto', 'danger');
                $this->redirect('/register');
            }

            if ($userModel->findByEmail($email)) {
                $this->setFlash('Email je vec zauzet', 'danger');
                $this->redirect('/register');
            }

            $userId = $userModel->register([
                'username' => $username,
                'email' => $email,
                'full_name' => $fullName,
                'password' => $password,
                'role' => 'user'
            ]);

            if ($userId) {
                $this->setFlash('Uspesna registracija! Mozete se prijaviti.', 'success');
                $this->redirect('/login');
            } else {
                $this->setFlash('Greska pri registraciji. Pokusajte ponovo', 'danger');
                $this->redirect('/register');
            }
        }

        $this->render('auth/register', [
            'title' => 'Registracija'
        ]);
    }

    public function logout()
    {
        session_destroy();
        $this->setFlash('Uspesno ste se odjavili.', 'success');
        $this->redirect('/login');
    }
}
