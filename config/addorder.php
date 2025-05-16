<?php
session_start();
// Include the database connection file
include('conn.inc.php');
$conn = openConnection();

// Check if the AJAX request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the form
    $quantity = $_POST['quantity'];
    $address = $_SESSION['address'];
    $sph_id = $_POST['sph_id'];
    $total_price = (int) $_POST['total_price'];
    $userid = $_SESSION['user_id'] ?? null;
    $usertype = $_SESSION['user_type'] ?? null;
    $created = date("Y-m-d");

echo $total_price;
    // Sanitize input to avoid SQL injection (for basic example)
    $quantity = mysqli_real_escape_string($conn, $quantity);
    $address = mysqli_real_escape_string($conn, $address);
    $sph_id = mysqli_real_escape_string($conn, $sph_id);
    $usertype = mysqli_real_escape_string($conn, $usertype);
    $userid = mysqli_real_escape_string($conn, $userid);

    // Correct the comparison operator from "=" to "=="
    if ($usertype == "SE") {
        $sql = "INSERT INTO orders (se_qty, address, sph_id, se_id,created_date, total_cost) 
                VALUES ('$quantity', '$address', '$sph_id', '$userid','$created', '$total_price')";
    } elseif ($usertype == "SH") {
        $sql = "INSERT INTO orders (sh_qty, address, sph_id, sh_id,created_date, total_cost) 
                VALUES ('$quantity', '$address', '$sph_id', '$userid','$created', '$total_price')";
    } elseif ($usertype == "CH") {
        $sql = "INSERT INTO orders (ch_qty, address, sph_id, ch_id,created_date, total_cost) 
                VALUES ('$quantity', '$address', '$sph_id', '$userid','$created', '$total_price')";
    } elseif ($usertype == "TM") {
        $sql = "INSERT INTO orders (tm_qty, address, sph_id, tm_id,created_date, total_cost) 
                VALUES ('$quantity', '$address', '$sph_id', '$userid','$created', '$total_price')";
    } else {
        $sql = "INSERT INTO orders (zh_qty, address, sph_id, zh_id,created_date, total_cost) 
                VALUES ('$quantity', '$address', '$sph_id', '$userid','$created', '$total_price')";
    }

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Return success message
        echo "success";
    } else {
        // Return error message if insertion fails
        echo "error";
    }
}
?>
