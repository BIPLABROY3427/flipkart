
<?php
    include('../inc/conn.php');
     
    if($_POST['page']=='pay1'){
        $sql_insert = "UPDATE setting set pay1='".$_POST['status']."' WHERE id='".$_POST['id']."'"; 
        $query_insert = mysqli_query($con, $sql_insert);
        if($query_insert){
            if($_POST['status']=='1'){
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Enable Succefully');
            }else{
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Disable Succefully');
            }
        }else{
            $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
        } 
    }
    if($_POST['page']=='pay2'){
        $sql_insert = "UPDATE setting set pay2='".$_POST['status']."' WHERE id='".$_POST['id']."'"; 
        $query_insert = mysqli_query($con, $sql_insert);
        if($query_insert){
            if($_POST['status']=='1'){
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Enable Succefully');
            }else{
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Disable Succefully');
            }
        }else{
            $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
        } 
    }
    if($_POST['page']=='pay3'){
        $sql_insert = "UPDATE setting set pay3='".$_POST['status']."' WHERE id='".$_POST['id']."'"; 
        $query_insert = mysqli_query($con, $sql_insert);
        if($query_insert){
            if($_POST['status']=='1'){
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Enable Succefully');
            }else{
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Disable Succefully');
            }
        }else{
            $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
        } 
    }
    if($_POST['page']=='pay4'){
        $sql_insert = "UPDATE setting set pay4='".$_POST['status']."' WHERE id='".$_POST['id']."'"; 
        $query_insert = mysqli_query($con, $sql_insert);
        if($query_insert){
            if($_POST['status']=='1'){
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Enable Succefully');
            }else{
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Disable Succefully');
            }
        }else{
            $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
        } 
    }
    if($_POST['page']=='pay5'){
        $sql_insert = "UPDATE setting set pay5='".$_POST['status']."' WHERE id='".$_POST['id']."'"; 
        $query_insert = mysqli_query($con, $sql_insert);
        if($query_insert){
            if($_POST['status']=='1'){
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Enable Succefully');
            }else{
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Disable Succefully');
            }
        }else{
            $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
        } 
    }
    echo json_encode($jsonArr);
    mysqli_close($con);
?>











    