<?php
session_start();
include "conn.inc.php";
include "functions.php";
$conn = openConnection();

// Get filter values from request
$reportType = $_GET['reportType'] ?? '';
$dateRange = $_GET['dateRange'] ?? 'month';
$fromDate = $_GET['fromDate'] ?? '';
$toDate = $_GET['toDate'] ?? '';
$status = $_GET['status'] ?? '';
$userType = $_GET['userType'] ?? '';

// Set default filename with user type and date
$fileName = strtoupper($userType) . "_report_" . date('Y-m-d') . ".csv";

// Build SQL query based on user type and filters
$sql = "";
$headers = [];

switch ($userType) {
    case 'SE':
        $sql = "SELECT o.id, o.address, o.se_qty, o.total_cost, o.created_date, 
                       u.name as tm_name, d.qty as dispatch_qty
                FROM orders o
                LEFT JOIN user u ON o.tm_id = u.id
                LEFT JOIN dispatch d ON o.id = d.order_id
                WHERE o.se_id = " . $_SESSION['user_id'];
        $headers = ['Order ID', 'Address', 'Quantity', 'Total Cost', 'Order Date', 'TM Name', 'Dispatch Qty'];
        break;
        
    case 'TM':
        $sql = "SELECT o.id, o.address, o.tm_qty, o.total_cost, o.created_date, 
                       u.name as ch_name, d.qty as dispatch_qty
                FROM orders o
                LEFT JOIN user u ON o.ch_id = u.id
                LEFT JOIN dispatch d ON o.id = d.order_id
                WHERE o.tm_id = " . $_SESSION['user_id'];
        $headers = ['Order ID', 'Address', 'Quantity', 'Total Cost', 'Order Date', 'CH Name', 'Dispatch Qty'];
        break;
        
    case 'ZH':
        $sql = "SELECT o.id, o.address, o.zh_qty, o.zh_qty, o.total_cost, o.created_date, 
                       u.name as sh_name
                FROM orders o
                LEFT JOIN user u ON o.sh_id = u.id
                WHERE o.zh_id = " . $_SESSION['user_id'];
        $headers = ['Order ID', 'Address', 'Total Qty', 'ZH Qty', 'Total Cost', 'Order Date', 'SH Name'];
        break;
        
    case 'CH':
        $sql = "SELECT o.id, o.address, o.ch_qty, o.ch_qty, o.total_cost, o.created_date, 
                       u.name as tm_name, d.qty as dispatch_qty
                FROM orders o
                LEFT JOIN user u ON o.tm_id = u.id
                LEFT JOIN dispatch d ON o.id = d.order_id
                WHERE o.ch_id = " . $_SESSION['user_id'];
        $headers = ['Order ID', 'Address', 'Total Qty', 'CH Qty', 'Total Cost', 'Order Date', 'TM Name', 'Dispatch Qty'];
        break;
        
    case 'SH':
        $sql = "SELECT o.id, o.address, o.sh_qty, o.sh_qty, o.total_cost, o.created_date, 
                       u.name as zh_name
                FROM orders o
                LEFT JOIN user u ON o.zh_id = u.id
                WHERE o.sh_id = " . $_SESSION['user_id'];
        $headers = ['Order ID', 'Address', 'Total Qty', 'SH Qty', 'Total Cost', 'Order Date', 'ZH Name'];
        break;
        
    case 'RQ':
        $sql = "SELECT o.id, o.address, o.zh_qty, o.total_cost, o.created_date, 
                       d.qty as dispatch_qty, d.created_date as dispatch_date
                FROM orders o
                LEFT JOIN dispatch d ON o.id = d.order_id";
        $headers = ['Order ID', 'Address', 'Order Quantity', 'Total Cost', 'Order Date', 'Dispatch Qty', 'Dispatch Date'];
        break;
        
    default:
        // Default report for admin or unknown types
        $sql = "SELECT o.id, o.address, o.qty, o.total_cost, o.created_date, 
                       u1.user_name as zh_name, u2.user_name as sh_name, 
                       u3.user_name as ch_name, u4.user_name as tm_name,
                       d.qty as dispatch_qty
                FROM orders o
                LEFT JOIN user u1 ON o.zh_id = u1.id
                LEFT JOIN user u2 ON o.sh_id = u2.id
                LEFT JOIN user u3 ON o.ch_id = u3.id
                LEFT JOIN user u4 ON o.tm_id = u4.id
                LEFT JOIN dispatch d ON o.id = d.order_id";
        $headers = ['Order ID', 'Address', 'Quantity', 'Total Cost', 'Order Date', 
                   'ZH Name', 'SH Name', 'CH Name', 'TM Name', 'Dispatch Qty'];
        break;
}

// Apply date filter
$dateCondition = "";
switch ($dateRange) {
    case 'today':
        $dateCondition = "DATE(o.created_date) = CURDATE()";
        break;
    case 'week':
        $dateCondition = "o.created_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
        break;
    case 'month':
        $dateCondition = "o.created_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        break;
    case 'quarter':
        $dateCondition = "o.created_date >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)";
        break;
    case 'year':
        $dateCondition = "o.created_date >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
        break;
    case 'custom':
        if (!empty($fromDate) && !empty($toDate)) {
            $dateCondition = "o.created_date BETWEEN '" . mysqli_real_escape_string($conn, $fromDate) . 
                             "' AND '" . mysqli_real_escape_string($conn, $toDate) . "'";
        }
        break;
}

if (!empty($dateCondition)) {
    $sql .= (strpos($sql, 'WHERE') === false ? ' WHERE ' : ' AND ');
    $sql .= $dateCondition;
}

// Apply status filter (if applicable)
// if (!empty($status)) {
//     $sql .= (strpos($sql, 'WHERE') === false ? ' WHERE ' : ' AND ');
//     $sql .= "o.status = '" . mysqli_real_escape_string($conn, $status) . "'";
// }

// Execute query
$result = mysqli_query($conn, $sql);

// Set headers to force download
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=\"$fileName\"");
header("Pragma: no-cache");
header("Expires: 0");

$output = fopen("php://output", "w");

// Add UTF-8 BOM for Excel compatibility
fputs($output, "\xEF\xBB\xBF");

// Add column headers
fputcsv($output, $headers);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Format dates if they exist
        if (isset($row['created_date'])) {
            $row['created_date'] = date('Y-m-d H:i', strtotime($row['created_date']));
        }
        if (isset($row['dispatch_date'])) {
            $row['dispatch_date'] = date('Y-m-d H:i', strtotime($row['dispatch_date']));
        }
        
        fputcsv($output, array_values($row));
    }
} else {
    fputcsv($output, ['No data found matching your criteria']);
}

fclose($output);
exit;
?>