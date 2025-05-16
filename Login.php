<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
    
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">  
            <h2 class="text-center mb-4">Sign In</h2>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="user" class="form-label">User Type</label>
                    <select class="form-select" id="userType" name="userType" required>
                        <option value="" disabled>Select User Type</option>
                        <option value="RQ">Requesist</option>
                        <option value="ZH">Zonal Head</option>
                        <option value="SH">State Head</option>
                        <option value="CH">Costal Head</option>
                        <option value="TM">Teratory Manager</option>
                        <option value="SE">Sales Executive</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <div class="d-grid mb-3">
                    <button type="submit" class="auth-btn">Sign In</button>
                </div>
                
                <div class="auth-footer">
                    Don't have an account? <a href="register.php">Sign Up</a>
                </div>
            </form>
                <div>
                  <span id="errorMessage" class="text-danger mt-2 d-none"></span>
                </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
<script>
$(document).ready(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        const email = $('#email').val();
        const userType = $('#userType').val();
        const password = $('#password').val();

        $.ajax({
            url: 'config/login',
            method: 'POST',
            data: {
                email,
                userType,
                password
            },
            //dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    window.location.href = 'Dashboard.php';
                } else {
                    $('#errorMessage').removeClass('d-none').text(response.message);
                }
            },
            error: function(xhr, status, error) {
    console.error('XHR:', xhr);
    console.error('Status:', status);
    console.error('Error:', error);
    console.log('Response Text:', xhr.responseText); // This is key
    $('#errorMessage').removeClass('d-none').text('Server error: ' + xhr.status);
}
        });
    });
});

</script>

</body>
</html>