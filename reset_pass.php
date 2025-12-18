<?php
include 'db_connect.php';
$id = 20;
$password = password_hash('password123', PASSWORD_DEFAULT);
$conn->query("UPDATE users SET password='$password' WHERE id=$id");
echo "Password for user $id updated to 'password123'\n";
?>