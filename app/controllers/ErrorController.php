<?php

/**
 * Error Controller
 * Kontroler za prikaz grešaka (404)
 */

class ErrorController extends Controller
{
    // 404 - stranica nije pronađena
    public function notFound()
    {
        header("HTTP/1.0 404 Not Found");
        echo '<h1>404 - Stranica nije pronađena</h1>';
        echo '<p>Stranica koju tražite ne postoji.</p>';
        echo '<p><a href="' . BASE_URL . '">Nazad na početnu</a></p>';
    }
}
