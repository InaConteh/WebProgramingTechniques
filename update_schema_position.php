<?php
include 'db_connect.php';

$sql = "ALTER TABLE players ADD COLUMN position VARCHAR(50) DEFAULT 'N/A' AFTER club";

if ($conn->query($sql) === TRUE) {
    echo "Table 'players' updated successfully with 'position' column.";
} else {
    echo "Error updating table: " . $conn->error;
}

$conn->close();
?>