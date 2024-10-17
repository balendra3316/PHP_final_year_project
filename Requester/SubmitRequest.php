<?php
define('TITLE', 'Submit Request');
define('PAGE', 'SubmitRequest');
include('includes/header.php');
include('../dbConnection.php');
session_start();

$msg = '';
$requestId = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitrequest'])) {
    // Validate form fields
    $requiredFields = ['requestinfo', 'requestdesc', 'requestername', 'requesteradd1', 'requesteradd2', 'requestercity', 'requesterstate', 'requesterzip', 'requesteremail', 'requestermobile', 'requestdate'];
    $errors = [];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $errors[] = "$field is required";
        }
    }

    if (!empty($errors)) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fields </div>';
    } else {
        // Validate Name: Only letters and spaces allowed
        if (!preg_match("/^[A-Za-z\s]+$/", $_POST['requestername'])) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Name must contain only letters and spaces </div>';
        }
        // Validate Email Format and Domain
        elseif (!filter_var($_POST['requesteremail'], FILTER_VALIDATE_EMAIL) || !preg_match("/@gmail\.com$/", $_POST['requesteremail'])) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Invalid Google Email Address </div>';
        }
        // Validate Mobile Number Length
        elseif (!preg_match("/^\d{10}$/", $_POST['requestermobile'])) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Mobile number must be 10 digits </div>';
        }
        // Validate Zip Code Length and Format
        elseif (!preg_match("/^\d{6}$/", $_POST['requesterzip'])) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Zip code must be exactly 6 digits </div>';
        }
        // Validate Date: Must be a future date
        elseif (strtotime($_POST['requestdate']) < strtotime('today')) {
            $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Please select a future date </div>';
        } else {
            // Assign form data to variables
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

            // Insert data into the database
            $sql = "INSERT INTO submitrequest_tb(request_info, request_desc, requester_name, requester_add1, requester_add2, requester_city, requester_state, requester_zip, requester_email, requester_mobile, request_date) VALUES ('$rinfo','$rdesc', '$rname', '$radd1', '$radd2', '$rcity', '$rstate', '$rzip', '$remail', '$rmobile', '$rdate')";

            if ($conn->query($sql) === TRUE) {
                // Fetch the request ID from the database
                $result = $conn->query("SELECT LAST_INSERT_ID() AS request_id");
                $row = $result->fetch_assoc();
                $requestId = $row['request_id'];
                $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Form submitted successfully! Request ID: ' . $requestId . '</div>';
            } else {
                $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Submit Your Request </div>';
            }
        }
    }
}
?>
<div class="col-sm-9 col-md-10 mt-5">
    <form class="mx-5" id="requestForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label for="inputRequestInfo">Request Info</label>
            <select class="form-control" id="inputRequestInfo" name="requestinfo" required>
                <option value="">Select Service</option>
                <option value="Plumber">Plumber</option>
                <option value="Teacher">Teacher</option>
                <option value="Electrician">Electrician</option>
                <option value="Maid">Maid</option>
                <option value="Cook">Cook</option>
                <option value="Cleaner">Cleaner</option>
                <option value="Helper">Helper</option>
            </select>
        </div>
        <div class="form-group">
            <label for="inputRequestDescription">Description</label>
            <input type="text" class="form-control" id="inputRequestDescription" placeholder="Write Description" name="requestdesc" required>
        </div>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input type="text" class="form-control" id="inputName" placeholder="John Doe" name="requestername" pattern="[A-Za-z\s]+" title="Name must contain only letters and spaces." required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Address Line 1</label>
                <input type="text" class="form-control" id="inputAddress" placeholder="House No. 123" name="requesteradd1" required>
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress2">Address Line 2</label>
                <input type="text" class="form-control" id="inputAddress2" placeholder="Street Name" name="requesteradd2" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputCity">City</label>
                <input type="text" class="form-control" id="inputCity" name="requestercity" required>
            </div>
            <div class="form-group col-md-4">
                <label for="inputState">State</label>
                <input type="text" class="form-control" id="inputState" name="requesterstate" required>
            </div>
            <div class="form-group col-md-2">
                <label for="inputZip">Zip</label>
                <input type="text" class="form-control" id="inputZip" name="requesterzip" pattern="\d{6}" title="Zip code must be exactly 6 digits" maxlength="6" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail">Email</label>
                <input type="email" class="form-control" id="inputEmail" name="requesteremail" required>
            </div>
            <div class="form-group col-md-2">
                <label for="inputMobile">Mobile</label>
                <input type="text" class="form-control" id="inputMobile" name="requestermobile" pattern="\d{10}" title="Mobile number must be 10 digits" maxlength="10" required>
            </div>
            <div class="form-group col-md-2">
                <label for="inputDate">Date</label>
                <input type="date" class="form-control" id="inputDate" name="requestdate" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-danger" name="submitrequest">Submit</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
    <!-- Display error/success message -->
    <?php if (!empty($msg)) echo $msg; ?>
</div>
<?php include('includes/footer.php');
$conn->close();
?>
