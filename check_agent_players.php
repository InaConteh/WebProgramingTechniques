<?php
include 'db_connect.php';
$agent_id = 20;
$result = $conn->query("SELECT id, name FROM players WHERE owner_id=$agent_id");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['id'] . " | Name: " . $row['name'] . PHP_EOL;
    }
} else {
    echo "No players found for agent 20." . PHP_EOL;
}
?>