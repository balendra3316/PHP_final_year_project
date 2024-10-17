<?php
define('TITLE', 'Status');
define('PAGE', 'CheckStatus');
include('includes/header.php'); 
include('../dbConnection.php');
session_start();
if($_SESSION['is_login']){
 $rEmail = $_SESSION['rEmail'];
} else {
 echo "<script> location.href='RequesterLogin.php'; </script>";
}
?>
<div class="col-sm-6 mt-5 mx-3">
  <!-- Search Block -->
  <form action="" class="mt-3 form-inline d-print-none">
    <div class="form-group mr-3">
      <label for="checkid">Enter Request ID: </label>
      <input type="text" class="form-control ml-3" id="checkid" name="checkid" onkeypress="isInputNumber(event)">
    </div>
    <button type="submit" class="btn btn-danger">Search</button>
  </form>
  <?php
  if(isset($_REQUEST['checkid'])){
    $sql = "SELECT * FROM assignwork_tb WHERE request_id = {$_REQUEST['checkid']}";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if(($row['request_id']) == $_REQUEST['checkid']){ ?>
  <h3 class="text-center mt-5">Assigned Work Details</h3>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td>Request ID</td>
        <td><?php if(isset($row['request_id'])) {echo $row['request_id']; } ?></td>
      </tr>
      <tr>
        <td>Request Info</td>
        <td><?php if(isset($row['request_info'])) {echo $row['request_info']; } ?></td>
      </tr>
      <tr>
        <td>Request Description</td>
        <td><?php if(isset($row['request_desc'])) {echo $row['request_desc']; } ?></td>
      </tr>
      <tr>
        <td>Name</td>
        <td><?php if(isset($row['requester_name'])) {echo $row['requester_name']; } ?></td>
      </tr>
      <tr>
        <td>Address Line 1</td>
        <td><?php if(isset($row['requester_add1'])) {echo $row['requester_add1']; } ?></td>
      </tr>
      <tr>
        <td>Address Line 2</td>
        <td><?php if(isset($row['requester_add2'])) {echo $row['requester_add2']; } ?></td>
      </tr>
      <tr>
        <td>City</td>
        <td><?php if(isset($row['requester_city'])) {echo $row['requester_city']; } ?></td>
      </tr>
      <tr>
        <td>State</td>
        <td><?php if(isset($row['requester_state'])) {echo $row['requester_state']; } ?></td>
      </tr>
      <tr>
        <td>Pin Code</td>
        <td><?php if(isset($row['requester_zip'])) {echo $row['requester_zip']; } ?></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><?php if(isset($row['requester_email'])) {echo $row['requester_email']; } ?></td>
      </tr>
      <tr>
        <td>Mobile</td>
        <td><?php if(isset($row['requester_mobile'])) {echo $row['requester_mobile']; } ?></td>
      </tr>
      <tr>
        <td>Assigned Date</td>
        <td><?php if(isset($row['assign_date'])) {echo $row['assign_date']; } ?></td>
      </tr>
      <tr>
        <td>Technician Name</td>
        <td>Zahir Khan</td>
      </tr>
      <tr>
        <td>Work Progress</td>
        <td><?php if(isset($row['work_progress'])) {echo $row['work_progress'] . '%'; } ?></td>
      </tr>
      <tr>
        <td>Customer Sign</td>
        <td></td>
      </tr>
      <tr>
        <td>Technician Sign</td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <div class="text-center">
    <form class="d-print-none d-inline mr-3"><input class="btn btn-danger" type="submit" value="Print" onClick="window.print()"></form>
    <form class="d-print-none d-inline" action="CheckStatus.php"><input class="btn btn-secondary" type="submit" value="Close"></form>
  </div>
  <?php } else {
      echo '<div class="alert alert-dark mt-4" role="alert">Your Request is Still Pending</div>';
    }
  }
  ?>

  <!-- Update Work Progress Block -->
  <form action="" class="mt-5 form-inline d-print-none" method="POST">
    <div class="form-group mr-3">
      <label for="updateid">Enter Request ID: </label>
      <input type="text" class="form-control ml-3" id="updateid" name="updateid" onkeypress="isInputNumber(event)">
    </div>
    <div class="form-group mr-3">
      <label for="progress">Work Progress (%): </label>
      <input type="number" class="form-control ml-3" id="progress" name="progress" min="0" max="100">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
  </form>
  <?php
  if(isset($_REQUEST['updateid']) && isset($_REQUEST['progress'])){
    $updateid = $_REQUEST['updateid'];
    $progress = $_REQUEST['progress'];
    $sql = "UPDATE assignwork_tb SET work_progress = '$progress' WHERE request_id = '$updateid'";
    if($conn->query($sql) === TRUE){
      echo '<div class="alert alert-success mt-4" role="alert">Work Progress Updated Successfully</div>';
    } else {
      echo '<div class="alert alert-danger mt-4" role="alert">Unable to Update Work Progress</div>';
    }
  }
  ?>

  <!-- Payment Status Block -->
  <form action="" class="mt-5 form-inline d-print-none" method="POST">
    <div class="form-group mr-3">
      <label for="paymentid">Enter Request ID: </label>
      <input type="text" class="form-control ml-3" id="paymentid" name="paymentid" onkeypress="isInputNumber(event)">
    </div>
    <button type="submit" class="btn btn-primary">Check Payment Status</button>
  </form>
  <?php
  if(isset($_REQUEST['paymentid'])){
    $sql = "SELECT * FROM assignwork_tb WHERE request_id = {$_REQUEST['paymentid']}";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if(($row['request_id']) == $_REQUEST['paymentid']){ ?>
      <h3 class="text-center mt-5">Payment Status Details</h3>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td>Request ID</td>
            <td><?php if(isset($row['request_id'])) {echo $row['request_id']; } ?></td>
          </tr>
          <tr>
            <td>Request Info</td>
            <td><?php if(isset($row['request_info'])) {echo $row['request_info']; } ?></td>
          </tr>
          <tr>
            <td>Payment</td>
            <td><?php if(isset($row['payment_status'])) {echo $row['payment_status']; } ?></td>
          </tr>
          <tr>
            <td>Total Payment in Rupees</td>
            <td><?php if(isset($row['total_payment'])) {echo $row['total_payment']; } ?></td>
          </tr>
          <tr>
            <td>Request Description</td>
            <td><?php if(isset($row['request_desc'])) {echo $row['request_desc']; } ?></td>
          </tr>
          <tr>
            <td>Name</td>
            <td><?php if(isset($row['requester_name'])) {echo $row['requester_name']; } ?></td>
          </tr>
          <tr>
            <td>Assigned Date</td>
            <td><?php if(isset($row['assign_date'])) {echo $row['assign_date']; } ?></td>
          </tr>
          <tr>
            <td>Technician Name</td>
            <td>Zahir Khan</td>
          </tr>
          <tr>
            <td>Work Progress</td>
            <td><?php if(isset($row['work_progress'])) {echo $row['work_progress'] . '%'; } ?></td>
          </tr>
        </tbody>
      </table>
      <div class="text-center">
        <form class="d-print-none d-inline mr-3"><input class="btn btn-danger" type="submit" value="Print" onClick="window.print()"></form>
        <form class="d-print-none d-inline" action="CheckStatus.php"><input class="btn btn-secondary" type="submit" value="Close"></form>
      </div>
    <?php } else {
        echo '<div class="alert alert-dark mt-4" role="alert">Invalid Request ID</div>';
      }
  }
  ?>

  <!-- Update Payment Status Block -->
  <form action="" class="mt-5 form-inline d-print-none" method="POST" onsubmit="return validatePaymentForm()">
    <div class="form-group mr-3">
      <label for="updatepaymentid">Enter Request ID: </label>
      <input type="text" class="form-control ml-3" id="updatepaymentid" name="updatepaymentid" onkeypress="isInputNumber(event)">
    </div>
    <div class="form-group mr-3">
      <label for="payment_status">Payment Status: </label>
      <select class="form-control ml-3" id="payment_status" name="payment_status">
        <option value="Completed">Completed</option>
        <option value="Not Completed">Not Completed</option>
      </select>
    </div>
    <div class="form-group mr-3">
      <label for="total_payment">Total Payment (in Rupees): </label>
      <input type="number" class="form-control ml-3" id="total_payment" name="total_payment" min="0">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
  </form>
  <?php
  if(isset($_REQUEST['updatepaymentid']) && isset($_REQUEST['payment_status']) && isset($_REQUEST['total_payment'])){
    $updatepaymentid = $_REQUEST['updatepaymentid'];
    $payment_status = $_REQUEST['payment_status'];
    $total_payment = $_REQUEST['total_payment'];
    $sql = "UPDATE assignwork_tb SET payment_status = '$payment_status', total_payment = '$total_payment' WHERE request_id = '$updatepaymentid'";
    if($conn->query($sql) === TRUE){
      echo '<div class="alert alert-success mt-4" role="alert">Payment Status and Total Payment Updated Successfully</div>';
    } else {
      echo '<div class="alert alert-danger mt-4" role="alert">Unable to Update Payment Status and Total Payment</div>';
    }
  }
  ?>

</div>
<!-- Only Number for input fields -->
<script>
  function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
      evt.preventDefault();
    }
  }

  function validatePaymentForm() {
    var requestId = document.getElementById('updatepaymentid').value;
    var totalPayment = document.getElementById('total_payment').value;

    if (requestId === "" || totalPayment === "") {
      alert("Please enter Request ID and Total Payment.");
      return false;
    }
    return true;
  }
</script>
<?php
include('includes/footer.php'); 
?>
