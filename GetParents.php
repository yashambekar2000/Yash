<?php
require 'DatabaseConnection.php';
require 'Members.php';

$member = new Members();
$parents = $member->getParents();

echo '<option value="">-- Select Parent --</option>';
foreach ($parents as $parent) {
    echo "<option value='{$parent['id']}'>{$parent['name']}</option>";
}
?>
