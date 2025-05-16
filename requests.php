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
$user_id=$_SESSION['user_id'];
$user_type=$_SESSION['user_type'];
$request=getrequests($conn,$user_id,$user_type);
?>

   <?php include "design/header.php"; ?>
    <main>
        <div class="orders-container">
            <div class="orders-header">
                <h1 class="orders-title">Requests</h1>
                <!-- <button class="btn-process">
                    <i class="fas fa-plus"></i> New Order
                </button> -->
            </div>
            
            <!-- <div class="search-filter">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search orders...">
                </div>
                <select class="filter-select">
                    <option>All Status</option>
                    <option>Pending</option>
                    <option>Shipped</option>
                    <option>Completed</option>
                    <option>Cancelled</option>
                </select>
            </div> -->
            
            <!-- Order Card 1 -->
             <?php foreach ($request as $req) { 
                $date=$req['created_date'];
                $formattedDate = date("M d, Y", strtotime($date));
                $imagePath = !empty($req['img']) ? 'config/upload/' . $req['img'] : 'config/upload/default.jpg'
                ?>
                
             
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <!-- <span class="order-id">#ORD-2023-001</span> -->
                        <span class="order-date"><?= $formattedDate ?></span>
                    </div>
                </div>
                
                <div class="order-details">
                    <div class="order-item">
                        <img src="<?= $imagePath ?>" alt="Product" class="order-item-img">
                        <div class="order-item-info">
                            <h5><?= $req['sp_name'] ?></h5>
                            <p>Qty: <?= $req['quantity'] ?></p>
                            <p>Sub Ordinate: <?= $req['u_name'] ?></p>
                            <p>Address:<?= $req['address'] ?> </p>
                        </div>
                    </div>
                </div>
                
                <div class="order-total">
                    Total:₹ <?php echo $req['total_cost']; ?>
                </div>
                
                <div class="order-actions">
                    <?php if ($req['user_id']==$user_id){?>
                        <span class="badge bg-success">Approved</span><?php } elseif($req['rmv']==null){ ?>
                    <button class="btn-view" onclick="openAllowModal('<?= $req['id']?>')">
                        <i class="fas fa-check-circle"></i> Allow
                    </button>
                    <button class="btn-process" onclick="openDisallowModal(<?= $req['id']?>)">
                        <i class="fas fa-times-circle"></i> Disallow
                    </button><?php } else{?><span class="badge bg-danger">Disapproved</span><?php }?>
                </div>
            </div>
            <?php }?>
        </div>
        <div id="allowModal" class="custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Approve Requests</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="approvalNotes" class="form-label">Quntity</label>
                        <input type="number" id="qty" class="form-input" placeholder="Enter Quantity">
                        <input type="hidden" id="order_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal btn-cancel" onclick="closeAllowModal()">Cancel</button>
                    <button class="btn-modal btn-confirm" id="approve">Submit Approval</button>
                </div>
            </div>
        </div>
        
        <!-- Disallow Modal -->
        <div id="disallowModal" class="custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Reject Request</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="del_id">
                    <p>Are you sure you want to reject this Request? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button class="btn-modal btn-cancel" onclick="closeDisallowModal()">No, Cancel</button>
                    <button class="btn-modal btn-confirm" id="reject">Yes, Reject</button>
                </div>
            </div>
        </div>
    </main>
    <?php include "design/footer.php"; ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        function openAllowModal(id) {
    $('#order_id').val(id); // set order id
    $('#allowModal').show(); // show modal
}
function openDisallowModal(id) {
    $('#del_id').val(id); // set order id
    $('#disallowModal').show(); // show modal
}
        $('#approve').on('click', function (e) {
    e.preventDefault();

    const order_id = parseInt($('#order_id').val());
    const quantity = parseInt($('#qty').val());


    if (!quantity) {
        alert("Please enter quantity.");
        return;
    }
    $.ajax({
        url: 'config/approve_request', // Change to your actual handler
        type: 'POST',
        data: {
            order_id,
            quantity
        },
        success: function (response) {
            alert(response);
            window.location.href = 'order.php';
        },
        error: function (xhr) {
            console.error("Error:", xhr.responseText);
            alert('Server error. Please try again.');
        }
    });
});
$('#reject').on('click', function (e) {
    e.preventDefault();

    const order_id = parseInt($('#del_id').val());
    $.ajax({
        url: 'config/reject_request', // Change to your actual handler
        type: 'POST',
        data: {order_id},
        success: function (response) {
            alert(response);
            location.reload()
            //window.location.href = 'order.php';
        },
        error: function (xhr) {
            console.error("Error:", xhr.responseText);
            alert('Server error. Please try again.');
        }
    });
});
    </script>
</body>
</html>