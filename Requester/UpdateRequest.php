<?php
define('TITLE', 'Update Request');
define('PAGE', 'UpdateRequest');
include('includes/header.php');
include('../dbConnection.php');
session_start();

$msg = '';
$requestData = [];

// Fetch request data based on request ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fetchrequest'])) {
    $requestId = $_POST['requestid'];
    $sql = "SELECT * FROM submitrequest_tb WHERE request_id = '$requestId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $requestData = $result->fetch_assoc();
    } else {
        $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Request ID not found </div>';
    }
}

// Update request data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updaterequest'])) {
    $requestId = $_POST['requestid'];
    $rinfo = $_POST['requestinfo'];
    $rdesc = $_POST['requestdesc'];
    $rname = $_POST['requestername'];
    $radd1 = $_POST['requesteradd1'];
    $radd2 = $_POST['requesteradd2'];
    $rcity = $_POST['requestercity'];
    $rstate = $_POST['requesterstate'];
    $rzip = $_POST['requesterzip'];
    $remail = $_POST['requesteremail'];
    $rmobile = $_POST['requestermobile'];
    $rdate = $_POST['requestdate'];

    $sql = "UPDATE submitrequest_tb SET request_info='$rinfo', request_desc='$rdesc', requester_name='$rname', requester_add1='$radd1', requester_add2='$radd2', requester_city='$rcity', requester_state='$rstate', requester_zip='$rzip', requester_email='$remail', requester_mobile='$rmobile', request_date='$rdate' WHERE request_id = '$requestId'";

    if ($conn->query($sql) === TRUE) {
        $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Update successful! Request ID: ' . $requestId . '</div>';
    } else {
        $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to update your request </div>';
    }
}
?>
<div class="col-sm-9 col-md-10 mt-5">
    <form class="mx-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group col-md-4">
            <label for="requestid">Enter Request ID</label>
            <input type="text" class="form-control" id="requestid" name="requestid" required>
        </div>
        <button type="submit" class="btn btn-danger" name="fetchrequest">Fetch Request</button>
    </form>

    <?php if (!empty($requestData)) { ?>
    <form class="mx-5 mt-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="requestid" value="<?php echo $requestData['request_id']; ?>">
        <div class="form-group">
            <label for="inputRequestInfo">Request Info</label>
            <select class="form-control" id="inputRequestInfo" name="requestinfo" required>
                <option value="">Select Service</option>
                <option value="Plumber" <?php if($requestData['request_info'] == 'Plumber') echo 'selected'; ?>>Plumber</option>
                <option value="Teacher" <?php if($requestData['request_info'] == 'Teacher') echo 'selected'; ?>>Teacher</option>
                <option value="Electrician" <?php if($requestData['request_info'] == 'Electrician') echo 'selected'; ?>>Electrician</option>
                <option value="Maid" <?php if($requestData['request_info'] == 'Maid') echo 'selected'; ?>>Maid</option>
                <option value="Cook" <?php if($requestData['request_info'] == 'Cook') echo 'selected'; ?>>Cook</option>
                <option value="Cleaner" <?php if($requestData['request_info'] == 'Cleaner') echo 'selected'; ?>>Cleaner</option>
                <option value="Helper" <?php if($requestData['request_info'] == 'Helper') echo 'selected'; ?>>Helper</option>
            </select>
        </div>
        <div class="form-group">
            <label for="inputRequestDescription">Description</label>
            <input type="text" class="form-control" id="inputRequestDescription" placeholder="Write Description" name="requestdesc" value="<?php echo $requestData['request_desc']; ?>" required>
        </div>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input type="text" class="form-control" id="inputName" placeholder="John Doe" name="requestername" pattern="[A-Za-z\s]+" title="Name must contain only letters and spaces." value="<?php echo $requestData['requester_name']; ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Address Line 1</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="House No. 123" name="requesteradd1" value="<?php echo $requestData['requester_add1']; ?>" required>
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress2">Address Line 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Street Name" name="requesteradd2" value="<?php echo $requestData['requester_add2']; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">City</label>
                <input type="text" class="form-control" id="inputCity" name="requestercity" value="<?php echo $requestData['requester_city']; ?>" required>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">State</label>
                <input type="text" class="form-control" id="inputState" name="requesterstate" value="<?php echo $requestData['requester_state']; ?>" required>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Zip</label>
                <input type="text" class="form-control" id="inputZip" name="requesterzip" pattern="\d{6}" title="Zip code must be exactly 6 digits" maxlength="6" value="<?php echo $requestData['requester_zip']; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="requesteremail" value="<?php echo $requestData['requester_email']; ?>" required>
            </div>
            <div class="form-group col-md-2">
                <label for="inputMobile">Mobile</label>
                <input type="text" class="form-control" id="inputMobile" name="requestermobile" pattern="\d{10}" title="Mobile number must be 10 digits" maxlength="10" value="<?php echo $requestData['requester_mobile']; ?>" required>
            </div>
            <div class="form-group col-md-2">
                <label for="inputDate">Date</label>
                <input type="date" class="form-control" id="inputDate" name="requestdate" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" value="<?php echo $requestData['request_date']; ?>" required>
            </div>
        </div>
        <button type="submit" class="btn btn-danger" name="updaterequest">Update</button>
    </form>
    <?php } ?>
    <!-- Display error/success message -->
    <?php if (!empty($msg)) echo $msg; ?>
</div>
<?php include('includes/footer.php');
$conn->close();
?>
