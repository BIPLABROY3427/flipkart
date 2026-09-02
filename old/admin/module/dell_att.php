<?php 
include("../inc/conn.php");
$pid=($_POST['pid']);
$type=($_POST['type']);
$del = mysqli_query($con,"delete from product_attributes where id = '$pid'");
    if($del){
        echo $type;
    }
?>

