<?php 
include("../inc/conn.php");
$pid=($_POST['pid']);
$type=($_POST['type']);
$image= mysqli_fetch_array($con->query("select * from product_color where id = '$pid'"));
$del = mysqli_query($con,"delete from product_color where id = '$pid'");
    if($del){
        unlink('../uploads/product/'.$image['product_images']); // correct
        echo $type;
    }
?>

