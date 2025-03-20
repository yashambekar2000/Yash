<?php
require_once 'DatabaseConnection.php';

class Members {
    private $pdo;

    public function __construct() {
        $this->pdo = DatabaseConnection::getInstance()->getConnection();
    }

    public function addMember($name, $parent_id = null) {
        $stmt = $this->pdo->prepare("INSERT INTO members (name, parent_id) VALUES (?, ?)");
        return $stmt->execute([$name, $parent_id]);
    }

    public function getMembers($parent_id = null) {
        $stmt = $this->pdo->prepare("SELECT * FROM members WHERE parent_id " . ($parent_id ? "= ?" : "IS NULL"));
        $stmt->execute($parent_id ? [$parent_id] : []);
        return $stmt->fetchAll();
    }
    public function getParents() {
        $stmt = $this->pdo->prepare("SELECT * FROM members");
        $stmt->execute(); 
        return $stmt->fetchAll();
    }
    public function renderTree($parent_id = null) {
        $members = $this->getMembers($parent_id);
        if ($members) {
            echo "<ul>";
            foreach ($members as $member) {
                echo "<li>{$member['name']}";
                $this->renderTree($member['id']); // Recursive call for children
                echo "</li>";
            }
            echo "</ul>";
        }
    }
}
?>
