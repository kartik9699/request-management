<?php
session_start();
include "config/conn.inc.php";
include "./config/functions.php";
$conn = openConnection();

$user_id = $_SESSION['user_id'] ?? null;
$user_type = $_SESSION['user_type'] ?? null;

// Optional: Redirect if not logged in
if (!$user_id || !$user_type) {
    header("Location: login.php"); // or your login page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        :root {
            --primary-color: #4f46e5;
            --hover-color: #4338ca;
            --text-color: #1e293b;
            --background-color: #f8fafc;
            --card-bg: #ffffff;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-bottom: 80px; /* Space for fixed order button */
        }

        .item-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .item-header {
            margin-bottom: 30px;
        }

        .item-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-color);
        }

        .item-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .item-gallery {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .main-image {
            width: 100%;
            height: 400px;
            object-fit: contain;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 20px;
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
        }

        .thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .thumbnail:hover, .thumbnail.active {
            border-color: var(--primary-color);
        }

        .item-details {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        .item-price {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin: 15px 0;
        }

        .item-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #64748b;
        }

        .item-description {
            line-height: 1.6;
            color: #334155;
            margin-bottom: 30px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .quantity-label {
            font-weight: 500;
            color: var(--text-color);
        }

        .quantity-input {
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            overflow: hidden;
        }

        .quantity-btn {
            background-color: #f1f5f9;
            border: none;
            width: 40px;
            height: 40px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background-color: #e2e8f0;
        }

        .quantity-value {
            width: 60px;
            height: 40px;
            text-align: center;
            border: none;
            border-left: 1px solid #cbd5e1;
            border-right: 1px solid #cbd5e1;
        }

        .order-footer {
            
            bottom: 0;
            left: 0;
            right: 0;
            background-color: var(--card-bg);
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.05);
            padding: 15px 0;
            z-index: 100;
        }

        .order-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-summary {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .order-price {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-color);
        }

        .order-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .order-btn:hover {
            background-color: var(--hover-color);
        }

        .order-btn:disabled {
            background-color: #cbd5e1;
            cursor: not-allowed;
        }

        @media (max-width: 768px) {
            .item-content {
                grid-template-columns: 1fr;
            }
            
            .main-image {
                height: 300px;
            }
            
            .order-container {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    
    
    <!-- Include your navbar component here -->
    
<?php include "design/header.php"; ?>
    <div class="item-container">
         <?php 
        $sph_id=$_GET['id'];
        $sphData=getSingleSPhData($conn,$sph_id);
        foreach($sphData as $data){

         $imagePath = !empty($data['img']) ? 'config/upload/' . $data['img'] : 'config/upload/default.jpg'
         ?>
        <div class="item-header">
            <h1 class="item-title text-dark"><?php echo $data['name']?></h1>
        </div>
       
        <div class="item-content">
            <div class="item-gallery">
                <img src="<?php echo $imagePath; ?>" alt="Headphones" class="main-image" id="mainImage">
            </div>
            
           <div class="item-order-wrapper">
    <div class="item-details">
        <div class="item-price" id="price">₹<?php echo $data['unit_cost']; ?></div>

        <div class="quantity-control">
            <span class="quantity-label text-dark">Quantity:</span>
            <div class="quantity-input">
                <button class="quantity-btn" onclick="updateQuantity(-1)">-</button>
                <input type="number" class="quantity-value" id="quantity" value="1" min="1">
                <button class="quantity-btn" onclick="updateQuantity(1)">+</button>
            </div>
        </div>
         
        <div class="order-container">
            <div class="order-summary">
                <span>Total:</span>
                <span class="order-price text-dark" id="totalPrice"></span>
                <input type="hidden" id="sph_id" value="<?= $data['id']?>">
                <input type="hidden" id="total_price">
            </div>

            <button class="order-btn" id="orderBtn">
                <i class="fas fa-shopping-cart"></i> Place Order
            </button>
        </div>
        <?php } ?>
    </div>

   
</div>

        </div>
    </div>
    <?php include "design/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const totalPrice = document.getElementById('totalPrice');
            const orderBtn = document.getElementById('orderBtn');
            const order_price= document.getElementById('total_price')
            let priceText = document.getElementById('price').textContent;
            let price = priceText.match(/[\d,.]+/);

            if (price) {
            let numericPrice = parseFloat(price[0].replace(/,/g, ''));
            console.log(numericPrice);
            } else {
            console.log("No number found");
            }
            // Update total price when quantity changes
            quantityInput.addEventListener('change', updateTotal);
            quantityInput.addEventListener('input', updateTotal);
            
            // Order button click handler
            // orderBtn.addEventListener('click', function() {
            //     const quantity = parseInt(quantityInput.value);
            //     alert(`Order placed for ${quantity} item(s). Total: ${(numericPrice * quantity).toFixed(2)}`);
            //     // In a real app, this would submit to your order processing system
            // });
            
            function updateTotal() {
                const quantity = parseInt(quantityInput.value);
                // Validate quantity
                if (quantity < 1) quantityInput.value = 1;
                if (quantity > 10000) quantityInput.value = 10000;
                
                // Update total
                totalPrice.textContent = `₹${(Number(price) * quantityInput.value).toFixed(2)}`;
                order_price.value=Number(price) * quantityInput.value;
                // Enable/disable order button if out of stock
                orderBtn.disabled = quantity < 1;
            }
            
            // Initialize total
            updateTotal();
        });
        
        function changeImage(thumbnail) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = thumbnail.src;
            
            // Update active thumbnail
            document.querySelectorAll('.thumbnail').forEach(img => {
                img.classList.remove('active');
            });
            thumbnail.classList.add('active');
        }
        
        function updateQuantity(change) {
            const quantityInput = document.getElementById('quantity');
            let newValue = parseInt(quantityInput.value) + change;
            
            // Validate min/max
            if (newValue < 1) newValue = 1;
            if (newValue > 10000) newValue = 25;
            
            quantityInput.value = newValue;
            
            // Trigger change event
            const event = new Event('change');
            quantityInput.dispatchEvent(event);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
 $('#orderBtn').on('click', function (e) {
  e.preventDefault();

  const sph_id = $('#sph_id').val();
  const total_price = $('#total_price').val();
  const quantity = $('#quantity').val();
  console.log(total_price);

  
  $.ajax({
    url: 'config/addorder',
    type: 'POST',
    // dataType: 'json', // Expect JSON response
    data: {
      sph_id,
      total_price,
      quantity
    },
    success: function (response) {
      alert(response);
       // $('#registerForm')[0].reset();
        window.location.href = 'order.php';
        //console.log("hello");
      
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