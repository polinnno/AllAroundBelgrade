<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include 'config.php';

$guideId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($guideId > 0) {
    $query = "DELETE FROM guide_locations WHERE guide_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $guideId);
    $stmt->execute();

    $query = "DELETE FROM guides WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $guideId);

    if($stmt->execute()){
        http_response_code(200);
        echo json_encode(array("message" => "Guide was deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete guide."));
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Invalid guide ID."));
}
?>
