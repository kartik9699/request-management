<?php
function openConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "client_pr"; // your database name

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
?>
