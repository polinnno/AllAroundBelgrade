<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'config.php';

$locationId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($locationId > 0) {
    $sql = "SELECT * FROM locations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $locationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $location = $result->fetch_assoc();
        echo json_encode($location);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Location not found."));
    }

    $stmt->close();
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid location ID."));
}

$conn->close();
?>
