<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
     <link rel="stylesheet" href="assets/css/item.css">
    
   
</head>
<?php
session_start();
include "config/conn.inc.php";
include "./config/functions.php";
$conn=openConnection();
$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['user_type'];
?>
<body>
    <?php include "design/header.php"; ?>
    <div class="items-container">
        <div class="page-header">
            <h2 class="page-title text-dark">All Items</h2>
            <!-- <button class="btn-edit">
                <i class="fas fa-plus"></i> Add New Item
            </button> -->
        </div>
        
        <div class="search-filter">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search items...">
            </div>
            <select class="filter-select">
                <option>All Categories</option>
                <?php 
                $phdata=getAllPhData($conn);
                foreach ($phdata as $data) { ?>
                     <option><?php echo $data['name']; ?></option>
               <?php }
                 ?>
            </select>
            <select class="filter-select">
                <option>Sort by: Newest</option>
                <option>Sort by: Oldest</option>
                <option>Sort by: Price (Low to High)</option>
                <option>Sort by: Price (High to Low)</option>
            </select>
        </div>
        
        <div class="items-grid">
            <!-- Item 1 -->
             <?php 
             $sphData=getAllSPhData($conn);
             foreach($sphData as $data){
                $imagePath = !empty($data['img']) ? 'config/upload/' . $data['img'] : 'config/upload/default.jpg'; ?>
            <a href="./item_details.php?id=<?php echo $data['id'] ?>">
            <div class="item-card">
                <img src="<?php echo $imagePath; ?>" alt="Item" class="item-image">
                <h2 class="item-name text-dark"><?php echo $data['name']; ?></h2>
                <!-- <span class="item-category">Electronics</span>
                <div class="item-price">$99.99</div>
                <div class="item-stock">
                    <i class="fas fa-box"></i>
                    <span>In Stock: 25</span>
                </div>
                <div class="item-actions">
                    <button class="btn-action btn-view">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <button class="btn-action btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                </div> -->
            </div>
            </a>
            <?php } ?>
         
        </div>
        
        <ul class="pagination">
            <li class="page-item"><a href="#" class="page-link">Previous</a></li>
            <li class="page-item"><a href="#" class="page-link active">1</a></li>
            <li class="page-item"><a href="#" class="page-link">2</a></li>
            <li class="page-item"><a href="#" class="page-link">3</a></li>
            <li class="page-item"><a href="#" class="page-link">Next</a></li>
        </ul>
    </div>
    <?php include "design/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/item.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>