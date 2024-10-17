<?php
define('TITLE', 'Pay Online');
define('PAGE', 'PayOnline');
include('includes/header.php');
include('../dbConnection.php');
session_start();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payonline'])) {
    $requestId = $_POST['requestid'];

    if (!empty($requestId)) {
        $msg = '<div class="alert alert-success mt-2" role="alert">After successful payment send Payment Screenshot and Request ID on whatsapp 6263972688</div>';
    } else {
        $msg = '<div class="alert alert-warning mt-2" role="alert">Please enter a valid Request ID</div>';
    }
}
?>
<div class="col-sm-9 col-md-10 mt-5">
    <form class="mx-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label for="inputRequestId">Enter Request ID</label>
            <input type="text" class="form-control" id="inputRequestId" placeholder="Enter Request ID" name="requestid" required>
        </div>
        <button type="submit" class="btn btn-danger" name="payonline">Submit</button>
    </form>

    <?php if (!empty($msg)) echo $msg; ?>

    <?php if (!empty($requestId)) { ?>
    <div class="mt-3">
        <img src="../images/qr-code.jpg" alt="QR Code for Payment" style="max-width: 300px;">
    </div>
    <?php } ?>
</div>

<?php include('includes/footer.php'); ?>
