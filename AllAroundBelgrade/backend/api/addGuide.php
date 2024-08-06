<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$description = $data['description'];
$locations = $data['locations'];
$created_by = $data['created_by'];
$created_at = date('Y-m-d H:i:s');

$sql = "INSERT INTO guides (name, description, created_at, created_by) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $description, $created_at, $created_by);

if ($stmt->execute()) {
    $guide_id = $stmt->insert_id;

    foreach ($locations as $location_id) {
        $sql = "INSERT INTO guide_locations (guide_id, location_id) VALUES (?, ?)";
        $locationStmt = $conn->prepare($sql);
        $locationStmt->bind_param("ii", $guide_id, $location_id);
        $locationStmt->execute();
    }

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
