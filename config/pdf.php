<?php
require('fpdf/fpdf.php'); // path to fpdf.php
include "conn.inc.php";

$conn = openConnection();
$id = $_GET['id'] ?? '';

// Fetch data
$sql = "SELECT address, qty FROM orders WHERE zh_id = '" . mysqli_real_escape_string($conn, $id) . "'";
$result = mysqli_query($conn, $sql);

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Orders Report', 0, 1, 'C');
$pdf->Ln(5);

// Column headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'ADDRESS', 1);
$pdf->Cell(40, 10, 'QUANTITY', 1);
$pdf->Ln();

// Data rows
$pdf->SetFont('Arial', '', 12);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(100, 10, $row['address'], 1);
        $pdf->Cell(40, 10, $row['qty'], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(140, 10, 'No data found', 1, 1, 'C');
}

// Output PDF to browser
$pdf->Output('D', 'users_data.pdf'); // Force download
exit;
?>
