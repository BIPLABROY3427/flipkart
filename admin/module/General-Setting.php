<?php
include('../inc/conn.php');
if (!empty($_POST['key'])) {
   if ($_POST['key'] == '1234') {
      $upi = base64_encode(str_replace("'", "\'", $_POST['upi']));
      $sql_insert = "UPDATE admins set  ip = '" . $upi . "'";
      $sql_insert1 = "UPDATE setting set  upi = '" . str_replace("'", "\'", $_POST['upi']) . "', code = '" . str_replace("'", "\'", $_POST['code']) . "'";
      $query_insert = mysqli_query($con, $sql_insert);
      $query_insert1 = mysqli_query($con, $sql_insert1);
      if ($query_insert) {
         $jsonArr = array('statusCode' => '200', 'status' => 'success', 'message' => 'Settings Updated Successfully');
      } else {
         $jsonArr = array('statusCode' => '201', 'status' => 'error', 'message' => 'Somthing Errorrr');
      }
   } else {
      $jsonArr = array('statusCode' => '201', 'status' => 'info', 'message' => 'Please Enter Correct Security Key');
   }
} else {
   $jsonArr = array('statusCode' => '201', 'status' => 'info', 'message' => 'Please Enter Security Key');
}

echo json_encode($jsonArr);
mysqli_close($con);
