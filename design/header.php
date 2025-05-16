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
// Get current page name
$current_page = basename($_SERVER['PHP_SELF'], '.php');
if($current_page == 'index') {
    $current_page = 'Dashboard'; // Adjust if your home page is index.php
}
?>
<header class="header">
    <div class="logo">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </div>
    
    <button class="mobile-menu-btn" id="mobileMenuBtn">
        <i class="fas fa-bars" id="menuIcon"></i>
    </button>
    <nav class="horizontal-navbar">
        <a href="Dashboard" class="<?php echo ($current_page == 'Dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <?php if($user_type != "RQ"): ?>
            <a href="order" class="<?php echo ($current_page == 'order') ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i>
                <span>Order</span>
            </a>
        <?php endif; ?>
        
        <?php if($user_type != "SE"): ?>
            <a href="requests" class="<?php echo ($current_page == 'requests') ? 'active' : ''; ?>">
                <i class="fas fa-comment-alt"></i>
                <span>Request</span>
            </a>
        <?php endif; ?>
        
        <a href="report" class="<?php echo ($current_page == 'report') ? 'active' : ''; ?>">
            <i class="fas fa-chart-pie"></i>
            <span>Reports</span>
        </a>
        <a href="config/logout">
            <i class="fa-solid fa-power-off"></i>                
            <span>Logout</span>
        </a>
    </nav>
</header>

<nav class="vertical-navbar" id="verticalNavbar">
    <div class="nav-links">
        <a href="Dashboard" class="<?php echo ($current_page == 'Dashboard') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
       <?php if($user_type != "RQ"): ?>
            <a href="order" class="<?php echo ($current_page == 'order') ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i>
                <span>Order</span>
            </a>
        <?php endif; ?>
        
        <?php if($user_type != "SE"): ?>
            <a href="requests" class="<?php echo ($current_page == 'requests') ? 'active' : ''; ?>">
                <i class="fas fa-comment-alt"></i>
                <span>Request</span>
            </a>
        <?php endif; ?>
        <a href="report" class="<?php echo ($current_page == 'report') ? 'active' : ''; ?>">
            <i class="fas fa-chart-pie"></i>
            <span>Reports</span>
        </a>
        <a href="config/logout">
            <i class="fa-solid fa-power-off"></i>                
            <span>Logout</span>
        </a>
    </div>
</nav>
<script src="../assets/js/script.js"></script>
</body>
</html>