<?php

/**
 * Error Controller
 * Kontroler za prikaz grešaka (404)
 */

class ErrorController extends Controller
{
    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        $this->render('errors/404', [
            'title' => 'Stranica nije pronađena'
        ]);
    }
}
