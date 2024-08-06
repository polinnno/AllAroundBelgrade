<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require 'config.php';

$input = json_decode(file_get_contents('php://input'), true);

$user_id = $input['user_id'];
$location_id = $input['location_id'];

$sql = "DELETE FROM location_bookmarks WHERE user_id = ? AND location_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $location_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
