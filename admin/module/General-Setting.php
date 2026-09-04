<?php
include('../inc/conn.php');

// Security check: Only allow authenticated admins
if (!isset($_SESSION['ID'])) {
   echo json_encode(array('statusCode' => '401', 'status' => 'error', 'message' => 'Unauthorized Access'));
   exit();
}

$upi = mysqli_real_escape_string($con, $_POST['upi'] ?? '');
$code = mysqli_real_escape_string($con, $_POST['code'] ?? '');

$sql_insert1 = "UPDATE setting SET upi = '$upi', code = '$code'";
$query_insert1 = mysqli_query($con, $sql_insert1);

if ($query_insert1) {
   // Also update admins table if that was required by the system
   $upi_b64 = base64_encode($upi);
   mysqli_query($con, "UPDATE admins SET ip = '$upi_b64'");

   $jsonArr = array('statusCode' => '200', 'status' => 'success', 'message' => 'Settings Updated Successfully');
} else {
   $jsonArr = array('statusCode' => '201', 'status' => 'error', 'message' => 'Something Errorrr');
}

echo json_encode($jsonArr);
mysqli_close($con);
