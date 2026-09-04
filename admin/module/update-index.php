<?php
include('../inc/conn.php');

if(isset($_POST['id']) && isset($_POST['index_val'])) {
    $id = (int)$_POST['id'];
    $index_val = (int)$_POST['index_val'];
    
    $sql_update = "UPDATE product SET admin_index = '$index_val' WHERE id = '$id'"; 
    $query_update = mysqli_query($con, $sql_update);
    
    if($query_update){
        $jsonArr = array('statusCode'=>'200', 'status'=>'success', 'message'=>'Rank Index Updated');
    } else {
        $jsonArr = array('statusCode'=>'201', 'status'=>'error', 'message'=>'Error updating Rank Index'); 
    }   
    echo json_encode($jsonArr);
    mysqli_close($con);
}
?>
