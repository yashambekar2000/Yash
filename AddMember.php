<?php
require_once 'Members.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $parent_id = $_POST['parent_id'] ?: null;

    $member = new Members();
    if ($member->addMember($name, $parent_id)) {
        echo "Member added successfully!";
    } else {
        echo "Error adding member.";
    }
}
?>
