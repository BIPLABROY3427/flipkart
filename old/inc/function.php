<?php
include('admin/inc/conn.php');
function admin($con){
	$sql="select * from admins";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function setting($con){
	$sql="select * from setting";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function get_banner($con){
	$sql="select * from banner WHERE status=1";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function check_product($con,$slug){
	$count = mysqli_num_rows($con->query("select * from product WHERE slug='".$slug."'"));
	if($count==0){
		return false;
	}else{
		return true;  
	}
}
function get_product($con,$id=''){
	$sql="SELECT * FROM `product` WHERE status='1' ";
	if($id!=''){
		$sql.=" and id=$id";
	}
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function get_gallery($con,$id=''){
	$sql="SELECT * FROM `product_images` WHERE product_id=$id";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function get_color($con,$id=''){
	$sql="SELECT * FROM `product_color` WHERE product_id=$id";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function get_attributes($con,$id=''){
	$sql="SELECT * FROM `product_attributes` WHERE product_id=$id";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function cal_percentage($num_amount, $num_total) {
    $count=100 - (($num_amount * 100) / $num_total);
	$result = explode('.',$count);
    return $result[0];
  }
?>