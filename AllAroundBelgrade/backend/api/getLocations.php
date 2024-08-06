<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'config.php';

$sql = "SELECT * FROM locations ORDER BY created_at";
$result = $conn->query($sql);

$locations = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}


echo json_encode($locations);
?>
