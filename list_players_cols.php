<?php
include 'db_connect.php';
$result = $conn->query("DESCRIBE players");
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . PHP_EOL;
}
?>