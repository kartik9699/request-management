<?php
include "conn.inc.php"; // DB connection
session_start();

$conn = openConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $qty = $_POST['quantity'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
    $user_type = $_SESSION['user_type'] ?? null;
    $date=date('y-m-d');
    if (!$order_id || !$qty || !$user_id || !$user_type) {
        http_response_code(400);
        echo "Invalid input.";
        exit;
    }

    // Determine which columns to update
    $qty_column = "";
    $user_column = "";
if ($user_type!="RQ"){
    switch ($user_type) {
        case 'ZH':
            $qty_column = "zh_qty";
            $user_column = "zh_id";
            break;
        case 'SH':
            $qty_column = "sh_qty";
            $user_column = "sh_id";
            break;
        case 'CH':
            $qty_column = "ch_qty";
            $user_column = "ch_id";
            break;
        case 'TM':
            $qty_column = "tm_qty";
            $user_column = "tm_id";
            break;
        case 'SE':
            $qty_column = "se_qty";
            $user_column = "se_id";
            break;
        default:
            http_response_code(400);
            echo "Invalid user type.";
            exit;
    }

    // Build SQL update query
    $sql = "UPDATE orders SET $qty_column = ?, $user_column = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $qty, $user_id, $order_id);
}
else{
    $sql="INSERT INTO `dispatch` (`order_id`, `qty`, `created_date`) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis",$order_id, $qty, $date);
}

    if ($stmt->execute()) {
        echo "Order updated successfully.";
    } else {
        http_response_code(500);
        echo "Error updating order: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo "Invalid request method.";
}
?>
