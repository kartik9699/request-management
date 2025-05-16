<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        
    </style>
</head>
<body>
    <?php
session_start();
include "config/conn.inc.php";
include "./config/functions.php";
$conn=openConnection();
$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['user_type'];
?>
   <?php include "design/header.php"; ?>
    <!-- Include your navbar component here -->
    <main>
        <div class="reports-container">
            <div class="reports-header">
                <h1 class="reports-title">Order & Dispatch Reports</h1>
            </div>
            
            <div class="report-filters">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Report Type</label>
                        <select class="filter-select" id="reportType">
                            <option value="">All Reports</option>
                            <option value="orders">Order Reports</option>
                            <option value="dispatch">Dispatch Reports</option>
                            <option value="inventory">Inventory Reports</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Date Range</label>
                        <select class="filter-select" id="dateRange">
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month" selected>This Month</option>
                            <option value="quarter">This Quarter</option>
                            <option value="year">This Year</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                </div>
                
                <div class="filter-row">
                    <div class="filter-group date-group">
                        <label class="filter-label">From Date</label>
                        <input type="date" class="filter-input" id="fromDate">
                    </div>
                    
                    <div class="filter-group date-group">
                        <label class="filter-label">To Date</label>
                        <input type="date" class="filter-input" id="toDate">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select class="filter-select" id="statusFilter">
                            <option value="">All Statuses</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="shipped">Shipped</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                
                <div class="report-actions">
                    <button class="btn-download" id="downloadReport">
                        <i class="fas fa-file-download"></i> Download Report
                    </button>
                </div>
            </div>
        </div>
    </main>
    <!-- Include your footer component here -->
    <?php include "design/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js">
        
    </script>
</body>
</html>