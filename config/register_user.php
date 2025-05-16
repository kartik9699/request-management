<?php
header('Content-Type: application/json');
require 'conn.inc.php';
$conn = openConnection();

// print_r($_POST); 
// exit;

// Safely get values
$name       = $_POST['name'] ?? null;
$email      = $_POST['email'] ?? null;
$user_type  = $_POST['user_type'] ?? null;
$password   = $_POST['password'] ?? null;

$zh_id      = isset($_POST['zh_id']) && $_POST['zh_id'] !== '' ? $_POST['zh_id'] : null;
$sh_id      = isset($_POST['sh_id']) && $_POST['sh_id'] !== '' ? $_POST['sh_id'] : null;
$ch_id      = isset($_POST['ch_id']) && $_POST['ch_id'] !== '' ? $_POST['ch_id'] : null;
$tm_id      = isset($_POST['tm_id']) && $_POST['tm_id'] !== '' ? $_POST['tm_id'] : null;

// Validate required fields
if (!$name || !$email || !$user_type || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
    exit;
}

// Optionally hash the password
// $password = password_hash($password, PASSWORD_BCRYPT);

$query = "INSERT INTO `user` (name, user_type, zh_id, sh_id, ch_id, tm_id, password)
          VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ssiiiss", $name, $user_type, $zh_id, $sh_id, $ch_id, $tm_id, $password);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
