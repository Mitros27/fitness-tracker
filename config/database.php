<?php
/**
 * Database Configuration
 * Konfiguracija i konekcija na bazu podataka
 */

class Database
{
    private static $instance = null;
    private $connection;

    // Database kredencijali za XAMPP
    private $host = 'localhost';
    private $database = 'fitness_tracker';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';

    // Konstruktor - pravi konekciju
    private function __construct()
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset={$this->charset}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);

        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Singleton pattern - vraća uvek istu instancu
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Vraća PDO konekciju
    public function getConnection()
    {
        return $this->connection;
    }

    // Zabranjuje kloniranje
    private function __clone()
    {
    }
}

// Globalna funkcija za lakši pristup
function db()
{
    return Database::getInstance()->getConnection();
}
?>