<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Rest of your PHP code

include 'config.php';

$data = json_decode(file_get_contents("php://input"));

$username = $data->username;
$password = $data->password;

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
//if ($user && ($password == $user['password'])) {
    $response = [
        'username' => $user['username'],
        'email' => $user['email'],
        'id' => $user['id']
    ];
    echo json_encode($response);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid username or password']);
}

$conn->close();
?>
