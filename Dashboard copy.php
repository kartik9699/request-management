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
include "config/functions.php";
include "config/conn.inc.php";
$conn=openConnection();
$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['user_type'];
$totalorder = gettotalorder($conn,$user_id,$user_type);
$completed=getcompletedorder($conn,$user_id,$user_type);
$remaining=$totalorder-$completed;
include "design/header.php"; 
?>
    <main class="main-content">
        <div class="container">
            <div class="box">
                <div class="box-header">Total order</div>
                <div class="box-content">
                    <i class="fas fa-shopping-cart icon"></i>
                    <span class="value"><?php echo $totalorder; ?></span>
                </div>
            </div>
            <div class="box">
                <div class="box-header">Completed Orders</div>
                <div class="box-content">
                    <i class="fas fa-shopping-cart icon"></i>
                    <span class="value"><?php echo $completed; ?></span>
                </div>
            </div>
            <div class="box">
                <div class="box-header">Remaining</div>
                <div class="box-content">
                    <i class="fas fa-shopping-cart icon"></i>
                    <span class="value"><?php echo $remaining; ?></span>
                </div>
            </div>
        </div>
        <section class="categories-section">
<?php 
$phdata = getAllPhData($conn);
$phCount = count($phdata);
foreach($phdata as $data){
    $ph_id = $data['id'];
    $sphData = getSPhData($conn, $ph_id);
?>
    <h2 class="section-heading"><?php echo $data['name']; ?></h2>
    <div class="categories-container">
        <?php 
        $limitedSphData = array_slice($sphData, 0, 3); // Get only first 3
        foreach ($limitedSphData as $data1) { 
            $imagePath = !empty($data1['img']) ? 'config/upload/' . $data1['img'] : 'config/upload/default.jpg';
            ?>
            <a href="item_details.php?id=<?php echo $data1['id'];?>" class="category-card">
                <div class="category-img">
                    <img src="<?php echo $imagePath ?>" alt="Category">
                </div>
                <div class="category-name"><?php echo $data1['name']; ?></div>
            </a>
        <?php } ?>
    </div>

    <?php if ($phCount > 3) { ?>
        <div class="view-all-container">
            <a href="item" class="view-all-btn">View All Items</a>
        </div>
    <?php } ?>
<?php } ?>
</section>

    </main>
    <?php include "design/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>