
<?php
    include('../inc/conn.php');
    $sql_insert = "DELETE FROM ".$_POST['page']." WHERE id='".$_POST['id']."'"; 
    $query_insert = mysqli_query($con, $sql_insert);
    if($query_insert){
        if($_POST['page']=='product'){
            mysqli_query($con, "DELETE FROM product_images WHERE product_id='".$_POST['id']."'"); 
            mysqli_query($con, "DELETE FROM product_attributes WHERE product_id='".$_POST['id']."'"); 
        }
        $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Deleted Succefully');
    }else{
        $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
    }   
    echo json_encode($jsonArr);
    mysqli_close($con);
?>











    