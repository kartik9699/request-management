<?php
include "conn.inc.php";
$conn = openConnection();

$fileName = "users_data.csv";
$id = $_GET['id'] ?? '';

$sql = "SELECT address, qty FROM orders WHERE zh_id = '" . mysqli_real_escape_string($conn, $id) . "'";
$result = mysqli_query($conn, $sql);

// Set headers to force download
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$fileName\"");

$output = fopen("php://output", "w");

// Add column headers
fputcsv($output, ['ADDRESS', 'QUANTITY']);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [$row['address'], $row['qty']]);
    }
} else {
    fputcsv($output, ['No data found']);
}

fclose($output);
exit;
?>
