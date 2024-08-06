<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include 'config.php';

$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$type = $data->type;
$image_url = $data->image_url;

$sql = "INSERT INTO locations (name, type, image_url) VALUES ('$name', '$type', '$image_url')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("message" => "Location added successfully"));
} else {
    echo json_encode(array("message" => "Error: " . $sql . "<br>" . $conn->error));
}
?>
