<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'config.php';

$sql = "SELECT * FROM guides";
$result = $conn->query($sql);
$guides = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $guide_id = $row['id'];

        $sql_locations = "SELECT locations.* FROM locations 
                          JOIN guide_locations ON locations.id = guide_locations.location_id 
                          WHERE guide_locations.guide_id = $guide_id";
        $result_locations = $conn->query($sql_locations);
        $locations = array();

        if ($result_locations->num_rows > 0) {
            while($row_location = $result_locations->fetch_assoc()) {
                $locations[] = $row_location;
            }
        }

        $row['locations'] = $locations;
        $guides[] = $row;
    }
}

echo json_encode($guides);
?>
