<?php
  include('dbConnection.php');

  if (isset($_REQUEST['rSignup'])) {
    // Checking for Empty Fields
    if (empty($_REQUEST['rName']) || empty($_REQUEST['rEmail']) || empty($_REQUEST['rPassword'])) {
      $regmsg = '<div class="alert alert-warning mt-2" role="alert"> All Fields are Required </div>';
    } else {
      // Validate Name: Must start with letters, can include numbers after letters
      if (!preg_match("/^[a-zA-Z]+[a-zA-Z0-9]*$/", $_REQUEST['rName'])) {
        $regmsg = '<div class="alert alert-warning mt-2" role="alert"> Name must start with letters and can include numbers after letters </div>';
      } 
      // Validate Email Format and Domain
      elseif (!filter_var($_REQUEST['rEmail'], FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail\.com$/", $_REQUEST['rEmail'])) {
        $regmsg = '<div class="alert alert-warning mt-2" role="alert"> Invalid Google Email Address </div>';
      } 
      // Validate Password Length
      elseif (strlen($_REQUEST['rPassword']) > 20) {
        $regmsg = '<div class="alert alert-warning mt-2" role="alert"> Password must be up to 20 characters long </div>';
      } else {
        // Check if Email is already registered
        $sql = "SELECT r_email FROM requesterlogin_tb WHERE r_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_REQUEST['rEmail']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
          $regmsg = '<div class="alert alert-warning mt-2" role="alert"> Email ID Already Registered </div>';
        } else {
          // Assigning User Values to Variables
          $rName = $_REQUEST['rName'];
          $rEmail = $_REQUEST['rEmail'];
          $rPassword = $_REQUEST['rPassword']; // No hashing, plain text
          $sql = "INSERT INTO requesterlogin_tb(r_name, r_email, r_password) VALUES (?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sss", $rName, $rEmail, $rPassword);
          if ($stmt->execute()) {
            $regmsg = '<div class="alert alert-success mt-2" role="alert"> Account Successfully Created </div>';
          } else {
            $regmsg = '<div class="alert alert-danger mt-2" role="alert"> Unable to Create Account </div>';
          }
        }
      }
    }
  }
?>  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <!-- Include Google Platform Library -->
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <!-- Set Google Client ID -->
  <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">
</head>
<body>
  <div class="container pt-5" id="registration">
    <h2 class="text-center">Create an Account</h2>
    <div class="row mt-4 mb-4">
      <div class="col-md-6 offset-md-3">
        <!-- Registration Form -->
        <form action="" class="shadow-lg p-4" method="POST">
          <div class="form-group">
            <i class="fas fa-user"></i>
            <label for="name" class="pl-2 font-weight-bold">Name</label>
            <input type="text" class="form-control" placeholder="Name" name="rName" pattern="[A-Za-z][A-Za-z0-9]*" title="Name must start with letters and can include numbers after letters.">
          </div>
          <div class="form-group">
            <i class="fas fa-user"></i>
            <label for="email" class="pl-2 font-weight-bold">Email</label>
            <input type="email" class="form-control" placeholder="Email" name="rEmail">
            <small class="form-text">We'll never share your email with anyone else.</small>
          </div>
          <div class="form-group">
            <i class="fas fa-key"></i>
            <label for="pass" class="pl-2 font-weight-bold">New Password</label>
            <input type="password" class="form-control" placeholder="Password" name="rPassword" maxlength="20">
          </div>
          <button type="submit" class="btn btn-danger mt-5 btn-block shadow-sm font-weight-bold" name="rSignup">Sign Up</button>
          <em style="font-size:10px;">Note - By clicking Sign Up, you agree to our Terms, Data Policy and Cookie Policy.</em>
          <?php if(isset($regmsg)) { echo $regmsg; } ?>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.querySelector('form').addEventListener('submit', function (e) {
      var nameInput = document.querySelector('input[name="rName"]');
      var namePattern = /^[A-Za-z][A-Za-z0-9]*$/;
      if (!namePattern.test(nameInput.value)) {
        alert('Name must start with letters and can include numbers after letters.');
        e.preventDefault(); // Prevent form submission
      }
      var emailInput = document.querySelector('input[name="rEmail"]');
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(emailInput.value) || !emailInput.value.endsWith('@gmail.com')) {
        alert('Please enter a valid Google email address.');
        e.preventDefault(); // Prevent form submission
      }
    });
  </script>
</body>
</html>
