<?php include('conn.php');
if(isset($_SESSION['ID'])){ 
    $id=$_SESSION['ID'];
    $get_admin= mysqli_fetch_array($con->query("select * from admins WHERE id='".$id."'"));
    $get_setting= mysqli_fetch_array($con->query("select * from setting"));
    if(time()-$_SESSION["login_time_stamp"] > 20*60){
		session_unset();
		session_destroy();
		echo "<script type='text/javascript'>window.location=\"index.php\";</script>";
	 }
}else{
    echo "<script type='text/javascript'>window.location=\"index.php\";</script>";
}


?>