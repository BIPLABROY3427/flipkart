<?php
include('../inc/conn.php');
$email=mysqli_real_escape_string($con, $_POST['username']);
$password=mysqli_real_escape_string($con, md5($_POST['password']));
$date=date('d-m-Y h:i:s');
    $check=mysqli_query($con,"select * from admins where username='$email' and password='$password'");
    if (mysqli_num_rows($check)>0)
    {  
        while($row = mysqli_fetch_array($check))
            {
                $_SESSION['USERNAME']=$row['username'];
                $_SESSION['NAME']=$row['name'];
                $_SESSION['ID']=$row['id'];
                $_SESSION["login_time_stamp"] = time();
                $ina = mysqli_query($con,"UPDATE `admins` SET `last_login` = '".$date."' where id = '".$row['id']."'");
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Login Successfully');
            }
        
    }else{
        $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Username or Password Incorrect');
    }
echo json_encode($jsonArr);
mysqli_close($con);
?>