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
$totalItems=gettotalitem($conn);
$dispatchOrders=gettotaldispatch($conn);
$totalcost=gettotalcost($conn);
$phdata = getAllPhData($conn);
include "design/header.php"; 
?>
    <main class="main-content">
        <?php if ($user_type != "RQ"){ ?>
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
<?php } else{?> 
    <div class="buttons d-flex justify-content-end align-items-center gap-3 flex-wrap my-4">
  <button type="button" class="btn btn-primary px-4 py-2 rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#exampleModal1">
    Add Categories
  </button>
  <button type="button" class="btn btn-success px-4 py-2 rounded-pill shadow" data-bs-toggle="modal" data-bs-target="#exampleModal2">
    Add Subcategories
  </button>
</div>

    <div class="container">
    
   
                <div class="box box-items">
                    <div class="box-header">Total Items</div>
                    <div class="box-content">
                        <i class="fas fa-boxes icon"></i>
                        <span class="value"><?php echo $totalItems; ?></span>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header">Total Orders</div>
                    <div class="box-content">
                        <i class="fas fa-clipboard-list icon"></i>
                        <span class="value"><?php echo $totalorder; ?></span>
                    </div>
                </div>
                <div class="box box-dispatch">
                    <div class="box-header">Dispatch Orders</div>
                    <div class="box-content">
                        <i class="fas fa-truck icon"></i>
                        <span class="value"><?php echo $dispatchOrders; ?></span>
                    </div>
                </div>
                <div class="box box-cost">
                    <div class="box-header">Total Cost</div>
                    <div class="box-content">
                        <i class="fas fa-money-bill-wave icon"></i>
                        <span class="value">₹<?php echo number_format($totalcost, 2); ?></span>
                    </div>
                </div>
            </div>
            <div class="container d-flex flex-wrap w-100">
    <div class="chart-container m-2 col-lg-6 col-md-6 col-sm-12">
        <h3 class="chart-title">Orders Overview</h3>
        <canvas id="ordersChart"></canvas>
    </div>
    
    <div class="chart-container m-2 col-lg-6 col-md-6 col-sm-12">
        <h3 class="chart-title">Monthly Cost Analysis</h3>
        <canvas id="costChart"></canvas>
    </div>

</div>
<?php } ?>
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Catogaries</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="categoryForm">
  <div class="modal-body">
    <div class="mb-3">
      <label for="categoryInput" class="form-label">New Category</label>
      <input type="text" class="form-control" id="categoryInput" name="category" placeholder="Enter new category name" required>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
  </div>
</form>

    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Sub Catogaries</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="sphForm" enctype="multipart/form-data">
          <div class="mb-3">
    <label for="subCategoryInput" class="form-label">Subcategory Name</label>
    <input type="text" class="form-control" id="subCategoryInput" name="subcategory" placeholder="Enter subcategory name">
  </div>
<div class="mb-3">
    <label for="subCategoryInput" class="form-label">Unit Cost</label>
    <input type="number" class="form-control" id="subCategoryInput" name="cost" placeholder="Enter Unit Cost">
  </div>
  <!-- Select Category -->
  <div class="mb-3">
    <label for="categorySelect" class="form-label">Select Existing Category</label>
    <select class="form-select" id="categorySelect" name="ph_id" required>
      <option selected disabled>Select a category</option>
      <?php foreach($phdata as $data){ ?>
      <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
      <?php } ?>
    </select>
  </div>

  <!-- Image Upload -->
  <div class="mb-3">
    <label for="imageUpload" class="form-label">Upload Image</label>
    <input class="form-control" type="file" name="img" id="imageUpload" accept="image/*" required>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
  </div>
</form>

    </div>
  </div>
</div>
    </main>
    <?php include "design/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        <?php if($user_type == 'RQ'): ?>
        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Total Orders', 'Completed', 'Dispatch', 'Remaining'],
                datasets: [{
                    label: 'Orders',
                    data: [<?php echo $totalorder; ?>, <?php echo $dispatchOrders; ?>, <?php echo $dispatchOrders; ?>, <?php echo $totalorder-$dispatchOrders; ?>],
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(220, 38, 38, 0.7)'
                    ],
                    borderColor: [
                        'rgba(79, 70, 229, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(220, 38, 38, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Cost Chart (sample data - replace with actual data from your database)
        const costCtx = document.getElementById('costChart').getContext('2d');
        const costChart = new Chart(costCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Monthly Cost ()',
                    data: [1200, 1900, 1500, 2000, 1800, 2200],
                    fill: false,
                    borderColor: 'rgb(124, 58, 237)',
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    tension: 0.1,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        <?php endif; ?>
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $('#sphForm').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
      url: 'config/insert_sph',  // backend PHP file
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        alert(response);
        $('#sphForm')[0].reset(); // clear form
      },
      error: function() {
        alert('Error occurred while saving data.');
      }
    });
    
  });
  $("#categoryForm").submit(function (e) {
      e.preventDefault();

      var category = $("#categoryInput").val().trim();

      if (category !== "") {
        $.ajax({
          url: "config/insert_category",
          type: "POST",
          data: { category: category },
          success: function (response) {
            alert(response);
            $("#categoryForm")[0].reset();

            // Close the modal (replace '#yourModalId' with your actual modal ID)
            var modalElement = document.getElementById('yourModalId');
            var modalInstance = bootstrap.Modal.getInstance(modalElement);
            modalInstance.hide();
          },
          error: function () {
            alert("Something went wrong. Try again.");
          }
        });
      } else {
        alert("Please enter a category name.");
      }
    });
</script>

</body>
</html>