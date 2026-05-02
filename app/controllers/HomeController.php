<?php
class HomeController extends Controller
{
    public function index()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        $this->render('home/index', [
            'title' => 'Dobrodosli'
        ]);
    }
}
