<?php
// config/Database.php
namespace App\config;
use PDO;
use PDOException;
use Exception; 
class Database {
    private static $instance = null;
    private $pdo;
    private $host = 'localhost';
    private $dbname = 'pizza_shop';
    private $user = 'root';
    private $password = '';

    private function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            // Добавим отладку
            error_log('Database connection error: ' . $e->getMessage());
            throw new Exception('Connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}