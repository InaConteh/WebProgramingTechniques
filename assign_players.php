<?php
include 'db_connect.php';
$agent_id = 20;
$result = $conn->query("SELECT id FROM players LIMIT 3");
while ($row = $result->fetch_assoc()) {
    $player_id = $row['id'];
    $conn->query("UPDATE players SET owner_id=$agent_id WHERE id=$player_id");
    echo "Assigned player $player_id to agent $agent_id\n";
}
?>