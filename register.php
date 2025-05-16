<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Dashboard</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    />
    <link rel="stylesheet" href="assets/css/login.css" />
  </head>
  <body>
    <?php

include "config/conn.inc.php";
include "./config/functions.php";
$conn=openConnection();
$getZH=getZH($conn);
$getSH=getSH($conn);
$getCH=getCH($conn);
$getTM=getTM($conn);
?>
    <div class="auth-container">
      <div class="auth-card">
        <!-- <div class="auth-logo">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </div> -->

        <h2 class="text-center mb-4">Create Account</h2>
          <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              name="name"
              placeholder="Enter your full name"
            />
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Enter your email"
            />
          </div>
          <div class="mb-3">
            <label for="user" class="form-label">User Type</label>
            <select class="form-control" name="user_type" id="user_type">
              <option value="" disabled>Select User Type</option>
              <option value="ZH">Zonal Head</option>
              <option value="SH">State Head</option>
              <option value="CH">Costal Head</option>
              <option value="TM">Teratory Manager</option>
              <option value="SE">Sales Executive</option>
            </select>
          </div>
          <div class="mb-3" id="SH">
            <label for="user" class="form-label">State Head</label>
            <select class="form-control" id="SH_ID">
              <option value="">Select State Head</option>
              <?php foreach($getSH as $data){ ?>
              <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3" id="TM">
            <label for="user" class="form-label">Territory Manager</label>
            <select class="form-control" id="TM_ID">
              <option value="">Select Territory Manager</option>
              <?php foreach($getTM as $data){ ?>
              <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3" id="ZH">
            <label for="user" class="form-label">Zonal Head</label>
            <select class="form-control" id="ZH_ID">
              <option value="">Select Zonal Head</option>
               <?php foreach($getZH as $data){ ?>
              <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3" id="CH">
            <label for="user" class="form-label">Costal Head</label>
            <select class="form-control" id="CH_ID">
              <option value="">Select Zonal Head</option>
              <?php foreach($getCH as $data){ ?>
              <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              placeholder="Create a password"
            />
          </div>

          <div class="mb-4">
            <label for="confirm-password" class="form-label"
              >Confirm Password</label
            >
            <input
              type="password"
              class="form-control"
              id="confirm-password"
              placeholder="Confirm your password"
            />
          </div>

          <div class="d-grid mb-3">
            <button type="button" class="auth-btn" id="signup">Sign Up</button>
          </div>

          <div class="auth-footer">
            Already have an account? <a href="Login.php">Sign In</a>
          </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/register.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
 $('#signup').on('click', function (e) {
  e.preventDefault();

  const password = $('#password').val();
  const confirmPassword = $('#confirm-password').val();

  if (password !== confirmPassword) {
    alert('Passwords do not match');
    return;
  }

  const name = $('#name').val();
  const email = $('#email').val();
  const user_type = $('#user_type').val();
  const zh_id = $('#ZH_ID').val();
  const sh_id = $('#SH_ID').val();
  const ch_id = $('#CH_ID').val();
  const tm_id = $('#TM_ID').val();

  $.ajax({
    url: 'config/register_user',
    type: 'POST',
    dataType: 'json', // Expect JSON response
    data: {
      name,
      email,
      user_type,
      password,
      zh_id,
      sh_id,
      ch_id,
      tm_id
    },
    success: function (response) {
      alert(response.message);
      if (response.status === 'success') {
       // $('#registerForm')[0].reset();
        window.location.href = 'Login.php';
      }
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
