<?php
session_start();
include 'conn.inc.php'; // include your db connection
$conn=openConnection();
$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $usertype = $_POST['usertype'];
    $userid = $_POST['userid'];
    $username = $_POST['username'];
    $type=null;

    // Optional: Hash the password if needed
    //$hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database
    if($usertype=="ZH"){
    $type="SH";
    $sql = "INSERT INTO user (name, password, user_type, zh_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $password, $type, $userid );
    }
    elseif($usertype=="SH"){
        $type="CH";
        $sql = "INSERT INTO user (name, password, user_type, sh_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $password, $type, $userid );
        }
        elseif($usertype=="CH"){
            $type="TM";
            $sql = "INSERT INTO user (name, password, user_type, ch_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $password, $type, $userid );
            }
            elseif($usertype=="TM"){
                $type="SE";
                $sql = "INSERT INTO user (name, password, user_type, tm_id) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssi", $name, $password, $type, $userid );
                }
    if ($stmt->execute()) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Database error: ' . $conn->error;
    }

    $stmt->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
