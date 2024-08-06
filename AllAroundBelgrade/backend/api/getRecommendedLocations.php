<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

// Fetch the latest 4 recommended locations (for account)
$sql = "SELECT * FROM locations ORDER BY created_at DESC LIMIT 4";
$result = $conn->query($sql);

$locations = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}

echo json_encode($locations);

$conn->close();
?>
