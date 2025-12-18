<?php
include 'db_connect.php';
$result = $conn->query("SELECT id, username, email FROM users WHERE role='agent'");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Username: " . $row['username'] . " | Email: " . $row['email'] . PHP_EOL;
    }
} else {
    echo "No agents found." . PHP_EOL;
}
?>