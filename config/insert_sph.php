<?php
include "conn.inc.php";
$conn=openConnection();
$ph_id = $_POST['ph_id'];
$name=$_POST['subcategory'];
$cost=$_POST['cost'];
$imageName = $_FILES['img']['name'];
$imageTmp = $_FILES['img']['tmp_name'];
$targetDir = "upload/";
$targetPath = $targetDir . basename($imageName);

// Move uploaded file
if (move_uploaded_file($imageTmp, $targetPath)) {
    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO sph (name,unit_cost,ph_id, img) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis",$name ,$cost,$ph_id, $imageName);

    if ($stmt->execute()) {
        echo "Data inserted successfully!";
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Failed to upload image.";
}

$conn->close();
?>
