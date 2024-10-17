<?php
define('TITLE', 'Success');
include('includes/header.php'); 
include('../dbConnection.php');
session_start();

if (!isset($_SESSION['is_login']) || !$_SESSION['is_login']) {
    echo "<script> location.href='RequesterLogin.php'; </script>";
    exit;
}

if (isset($_SESSION['rEmail'])) {
    $rEmail = $_SESSION['rEmail'];
} else {
    echo "<script> location.href='RequesterLogin.php'; </script>";
    exit;
}

if (isset($_SESSION['myid'])) {
    $requestId = $_SESSION['myid'];
    $sql = "SELECT * FROM submitrequest_tb WHERE request_id = $requestId";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
?>
        <div class='ml-5 mt-5'>
            <table class='table'>
                <tbody>
                    <tr>
                        <th>Request ID</th>
                        <td><?php echo $row['request_id']; ?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $row['requester_name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email ID</th>
                        <td><?php echo $row['requester_email']; ?></td>
                    </tr>
                    <tr>
                        <th>Request Info</th>
                        <td><?php echo $row['request_info']; ?></td>
                    </tr>
                    <tr>
                        <th>Request Description</th>
                        <td><?php echo $row['request_desc']; ?></td>
                    </tr>
                    <tr>
                        <td>
                            <form class='d-print-none'>
                                <input class='btn btn-danger' type='submit' value='Print' onClick='window.print()'>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php
    } else {
        echo "Failed";
    }
} else {
    echo "Request ID not found";
}
include('includes/footer.php'); 
$conn->close();
?>
