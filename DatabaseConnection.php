<?php
class DatabaseConnection{

    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dsn = "mysql:host=localhost;";
        $username = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS yash_db");
            $this->pdo->exec("USE yash_db");

            $this->pdo->exec("CREATE TABLE IF NOT EXISTS members (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                parent_id INT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (parent_id) REFERENCES members(id) ON DELETE CASCADE
            )");

           // -------------------Insert Initial Data (only if table is empty)---------------------
             $this->insertInitialData();

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

  // -------------------Insert Initial Data (only if table is empty)---------------------
    private function insertInitialData() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM members");
        $count = $stmt->fetchColumn();

        if ($count == 0) {
            $this->pdo->exec("INSERT INTO members (name, parent_id) VALUES 
                ('CEO', NULL),
                ('Member 1', 1),
                ('Member 2', 1),
                ('Member 3', 2),
                ('Member 4', 2),
                ('Member 5', 3)
            ");
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }

}

?>