<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$guideId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($guideId > 0) {
    // Fetch guide details
    $sql = "SELECT * FROM guides WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $guideId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $guide = $result->fetch_assoc();

        $locationsSql = "SELECT locations.* FROM locations 
                         JOIN guide_locations ON locations.id = guide_locations.location_id 
                         WHERE guide_locations.guide_id = ?";
        $locationsStmt = $conn->prepare($locationsSql);
        $locationsStmt->bind_param("i", $guideId);
        $locationsStmt->execute();
        $locationsResult = $locationsStmt->get_result();

        $locations = [];
        while ($row = $locationsResult->fetch_assoc()) {
            $locations[] = $row;
        }

        $guide['locations'] = $locations;

        echo json_encode($guide);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Guide not found."));
    }

    $stmt->close();
    $locationsStmt->close();
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid guide ID."));
}

$conn->close();
?>
