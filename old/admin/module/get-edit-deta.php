
<?php
    include('../inc/conn.php');
    if(isset($_REQUEST['page'])){
    if($_REQUEST['page']=='banner'){
        $data=mysqli_fetch_array($con->query("select * from ".$_POST['page']." WHERE id='".$_POST['id']."'"));
        $jsonArr=array('statusCode'=>'200','id'=>$data['id'],'image'=>$data['image'],'title'=>$data['title']);
    }}
    
    echo json_encode($jsonArr);
    mysqli_close($con);
?>











    