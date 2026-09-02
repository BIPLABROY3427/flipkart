
<?php
    include('../inc/conn.php');
    $sql_insert = "UPDATE ".$_POST['page']." set status='".$_POST['status']."' WHERE id='".$_POST['id']."'"; 
    $query_insert = mysqli_query($con, $sql_insert);
    if($query_insert){
        if($_POST['status']=='1'){
            $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Activated Succefully');
        }else{
            $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'InActivated Succefully');
        }
    }else{
        $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
    }   
    echo json_encode($jsonArr);
    mysqli_close($con);
?>











    