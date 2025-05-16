<?php
include "conn.inc.php"; // Adjust path if needed

$conn = openConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    $current_date = date('Y-m-d');

    $sql = "UPDATE orders SET removed_on = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $current_date, $order_id);

    if ($stmt->execute()) {
        echo "Request has been rejected successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

?>
