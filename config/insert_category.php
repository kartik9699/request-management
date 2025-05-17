<?php
include "conn.inc.php";
$conn=openConnection();
$category = isset($_POST['category']) ? trim($_POST['category']) : '';

if (!empty($category)) {
    $stmt = $conn->prepare("INSERT INTO ph (name) VALUES (?)");
    $stmt->bind_param("s", $category);

    if ($stmt->execute()) {
        echo "Category added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Category name is required.";
}

$conn->close();
?>
