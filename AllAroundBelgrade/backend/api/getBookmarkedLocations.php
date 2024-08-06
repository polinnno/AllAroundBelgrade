<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require 'config.php';

$input = json_decode(file_get_contents('php://input'), true);
$user_id = $input['user_id'];

$sql = "SELECT location_id FROM location_bookmarks WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$bookmarkedLocations = [];
while ($row = $result->fetch_assoc()) {
    $bookmarkedLocations[] = $row['location_id'];
}

echo json_encode(["bookmarkedLocations" => $bookmarkedLocations]);

$stmt->close();
$conn->close();
?>
