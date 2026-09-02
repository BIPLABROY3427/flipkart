<?php
include('../inc/conn.php');
include('../inc/imagecompress.php');
$location = '../uploads/profile/';
$time_profile = 'Admin-'.date("d-m-Y")."-".time() ;
$profile = basename($_FILES["image"]["name"]);
$file_profile = $time_profile."-".$profile;
$targetFile_profile = $location . $file_profile;
$imageSize = $_FILES["image"]["size"];
if($imageSize<500000){
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile_profile);
}else{
    $imageTemp = $_FILES["image"]["tmp_name"]; 
    $imageUploadPath = $location . $file_profile;
    $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
}

if(!empty($_FILES['image']['name'])){
    $sql_insert = "UPDATE admins set image = '".$file_profile."'";
}else{
    $sql_insert = "UPDATE admins set name= '".$_REQUEST['name']."', email= '".$_REQUEST['email']."'";
}
// echo $sql_insert;die;
$query_insert = mysqli_query($con, $sql_insert);
     if($query_insert){
        $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Profile Updated Successfully');
     }else{
        $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr');    
     }
    
echo json_encode($jsonArr);
mysqli_close($con);
?>