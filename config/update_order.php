<?php
session_start();
include "conn.inc.php";
$conn = openConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    $user_type = $_SESSION['user_type'];
    $user_id = $_SESSION['user_id'];

    if ($action == "allow") {
        if ($user_type == "ZH") {
            $update = "UPDATE orders SET zh_id='$user_id' WHERE id='$order_id'";
        } elseif ($user_type == "SH") {
            $update = "UPDATE orders SET sh_id='$user_id' WHERE id='$order_id'";
        } elseif ($user_type == "TM") {
            $update = "UPDATE orders SET tm_id='$user_id' WHERE id='$order_id'";
        } elseif ($user_type == "CH") {
            $update = "UPDATE orders SET ch_id='$user_id' WHERE id='$order_id'";
        } else {
            echo "Invalid user type.";
            exit;
        }
    } elseif ($action == "disallow") {
        $update = "UPDATE orders SET removed_on=NOW() WHERE id='$order_id'";
    } else {
        echo "Invalid action.";
        exit;
    }

    if (mysqli_query($conn, $update)) {
        echo "Order updated successfully!";
    } else {
        echo "Failed to update order.";
    }
} else {
    echo "Invalid request.";
}
?>
