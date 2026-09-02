<?php 

include('../../admin/inc/conn.php');
	$old_password=md5($_POST['old-password']);
	$new_password=md5($_POST['new-password']);
	$cnew_password=md5($_POST['cnew-password']);
	$t_pass=mysqli_query($con,"select * from admins where password='$old_password' AND id='".$_SESSION['ID']."'");
	if (mysqli_num_rows($t_pass)>0){
		
			$sql = "UPDATE `admins` SET `password` = '".$new_password."' WHERE `admins`.`id` = '".$_SESSION['ID']."'";
			if (mysqli_query($con, $sql)) {
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Password Updated Successfully!');
			}else {
                $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Network Problem!');
			}
	}else{
        $jsonArr=array('statusCode'=>'202','status'=>'info','message'=>'Incorrect Old Password');
	}
	echo json_encode($jsonArr);
    mysqli_close($con);
?>