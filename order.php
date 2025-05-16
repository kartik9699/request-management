<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Vertical Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
   
   <?php
session_start();
include "config/conn.inc.php";
include "./config/functions.php";
$conn=openConnection();
$userid = $_SESSION['user_id'];
      $user_type = $_SESSION['user_type'];

?>
<?php include "design/header.php"; ?>
    <main>
        <div class="orders-container">
            <div class="orders-header">
                <h1 class="orders-title">My Orders</h1>
            </div>
            <!-- Order Card 1 -->
             <?php 
             $orderData= myorder($conn,$user_type,$userid);
             foreach ($orderData as $odata) { 
                $date=$odata['created_date'];
                $formattedDate = date("M d, Y", strtotime($date));
                $imagePath = !empty($odata['img']) ? 'config/upload/' . $odata['img'] : 'config/upload/default.jpg'
                ?>
                <div class="order-card">
                <div class="order-header">
                    <div>
                        <!-- <span class="order-id">#ORD-2023-001</span> -->
                        <span class="order-date"><?= $formattedDate ?></span>
                    </div>
                    <!-- <span class="order-status status-completed">Completed</span> -->
                </div>
                
                <div class="order-details">
                    <div class="order-item">
                        <img src="<?php echo $imagePath; ?>" alt="Product" class="order-item-img">
                        <div class="order-item-info">
                            <h5><?= $odata['sp_name'] ?></h5>
                            <p>Qty:<?= $odata['quantity'] ?></p>
                            <p>Sub Ordinate: <?= isset($odata['u_name']) && $odata['u_name'] ? $odata['u_name'] : 'NA' ?></p>
                            <p>Address:<?= $odata['address'] ?> </p>
                        </div>
                    </div>
                    
                   
                </div>
                
                <div class="order-total">
                    Total:₹<?php echo $odata['total_cost']; ?>
                </div>
                
                <div class="order-actions">
                </div>
            </div>
            <?php }
             ?>
            
            
            <!-- Order Card 2 -->
           
        </div>
    </main>
    <?php include "design/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>