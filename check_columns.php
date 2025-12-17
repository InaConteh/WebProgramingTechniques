<?php
include 'db_connect.php';
$result = $conn->query("DESCRIBE players");
echo "Columns in players table:\n";
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
$conn->close();
?>