<?php
define('TITLE', 'Requester Profile');
define('PAGE', 'RequesterProfile');
include('includes/header.php'); 
include('../dbConnection.php');
session_start();

if($_SESSION['is_login']){
  $rEmail = $_SESSION['rEmail'];
} else {
  echo "<script> location.href='RequesterLogin.php'; </script>";
}

// Fetch user data
$sql = "SELECT * FROM requesterlogin_tb WHERE r_email='$rEmail'";
$result = $conn->query($sql);
if($result->num_rows == 1){
  $row = $result->fetch_assoc();
  $rName = $row["r_name"]; 
  $dob = $row["dob"];
  $mobile = $row["mobile"];
  $permanent_address = $row["permanent_address"];
  $city = $row["city"];
  $state = $row["state"];
  $occupation = $row["occupation"];
  $pincode = $row["pincode"];
  $gender = $row["gender"];
  $marital_status = $row["marital_status"];
  $languages = $row["languages"];
}

if(isset($_REQUEST['update'])){
  $rName = $_REQUEST['rName'];
  $newEmail = $_REQUEST['rEmail'];
  $dob = $_REQUEST['dob'];
  $mobile = $_REQUEST['mobile'];
  $permanent_address = $_REQUEST['permanent_address'];
  $city = $_REQUEST['city'];
  $state = $_REQUEST['state'];
  $occupation = $_REQUEST['occupation'];
  $pincode = $_REQUEST['pincode'];
  $gender = $_REQUEST['gender'];
  $marital_status = $_REQUEST['marital_status'];
  $languages = $_REQUEST['languages'];
  
  $valid = true;

  // Validate email
  if(empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL) || !str_ends_with($newEmail, "@gmail.com")) {
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Invalid Email (must end with @gmail.com) </div>';
    $valid = false;
  }

  // Validate name
  if(empty($rName) || !preg_match("/^[a-zA-Z ]*$/", $rName)) {
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Name must contain only letters and spaces </div>';
    $valid = false;
  }

  // Validate Date of Birth
  if(empty($dob) || strtotime($dob) > strtotime('today')) {
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Date of Birth must be a past date </div>';
    $valid = false;
  }

  // Validate mobile number
  if(empty($mobile) || !preg_match("/^\d{10}$/", $mobile)) {
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Mobile number must be 10 digits </div>';
    $valid = false;
  }

  // Validate pincode
  if(empty($pincode) || !preg_match("/^\d{6}$/", $pincode)) {
    $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Pincode must be exactly 6 digits </div>';
    $valid = false;
  }

  if($valid) {
    $sql = "UPDATE requesterlogin_tb SET 
      r_name = '$rName', 
      r_email = '$newEmail', 
      dob = '$dob', 
      mobile = '$mobile', 
      permanent_address = '$permanent_address', 
      city = '$city', 
      state = '$state', 
      occupation = '$occupation', 
      pincode = '$pincode', 
      gender = '$gender', 
      marital_status = '$marital_status', 
      languages = '$languages' 
    WHERE r_email = '$rEmail'";

    if($conn->query($sql) === TRUE){
      $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
      $_SESSION['rEmail'] = $newEmail;
    } else {
      $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
    }
  }
}
?>

<div class="col-sm-6 mt-5">
  <form class="mx-5" method="POST">
    <div class="form-group">
      <label for="inputEmail">Email</label>
      <input type="email" class="form-control" id="inputEmail" name="rEmail" value="<?php echo $rEmail ?>">
    </div>
    <div class="form-group">
      <label for="inputName">Name</label>
      <input type="text" class="form-control" id="inputName" name="rName" value="<?php echo $rName ?>">
    </div>
    <div class="form-group">
      <label for="inputDOB">Date of Birth</label>
      <input type="date" class="form-control" id="inputDOB" name="dob" value="<?php echo $dob; ?>">
    </div>
    <div class="form-group">
      <label for="inputMobile">Mobile</label>
      <input type="text" class="form-control" id="inputMobile" name="mobile" value="<?php echo $mobile; ?>" pattern="\d{10}" title="Mobile number must be 10 digits">
    </div>
    <div class="form-group">
      <label for="inputAddress">Permanent Address</label>
      <input type="text" class="form-control" id="inputAddress" name="permanent_address" value="<?php echo $permanent_address; ?>">
    </div>
    <div class="form-group">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity" name="city" value="<?php echo $city; ?>">
    </div>
    <div class="form-group">
      <label for="inputState">State</label>
      <input type="text" class="form-control" id="inputState" name="state" value="<?php echo $state; ?>">
    </div>
    <div class="form-group">
      <label for="inputOccupation">Occupation</label>
      <input type="text" class="form-control" id="inputOccupation" name="occupation" value="<?php echo $occupation; ?>">
    </div>
    <div class="form-group">
      <label for="inputPincode">Pincode</label>
      <input type="text" class="form-control" id="inputPincode" name="pincode" value="<?php echo $pincode; ?>" pattern="\d{6}" title="Pincode must be exactly 6 digits">
    </div>
    <div class="form-group">
      <label for="inputGender">Gender</label>
      <select class="form-control" id="inputGender" name="gender">
        <option value="Male" <?php if($gender == 'Male') echo 'selected'; ?>>Male</option>
        <option value="Female" <?php if($gender == 'Female') echo 'selected'; ?>>Female</option>
        <option value="Other" <?php if($gender == 'Other') echo 'selected'; ?>>Other</option>
      </select>
    </div>
    <div class="form-group">
      <label for="inputMaritalStatus">Marital Status</label>
      <select class="form-control" id="inputMaritalStatus" name="marital_status">
        <option value="Single" <?php if($marital_status == 'Single') echo 'selected'; ?>>Single</option>
        <option value="Married" <?php if($marital_status == 'Married') echo 'selected'; ?>>Married</option>
      </select>
    </div>
    <div class="form-group">
      <label for="inputLanguages">Languages Known</label>
      <input type="text" class="form-control" id="inputLanguages" name="languages" value="<?php echo $languages; ?>">
    </div>
    <button type="submit" class="btn btn-danger" name="update">Update</button>
    <?php if(isset($passmsg)) { echo $passmsg; } ?>
  </form>
</div>
</div>
</div>

<?php
include('includes/footer.php'); 
?>
