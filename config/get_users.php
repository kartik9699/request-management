// get_users.php
<?php
require 'conn.inc.php'; // connect $conn
$type = $_GET['type'] ?? '';
$data = [];
$conn=openConnection();
if (!empty($type)) {
    require 'functions.php'; // the file where getUsersByType is defined
    $data = getUsersByType($conn, $type);
}

header('Content-Type: application/json');
echo json_encode($data);
?>
