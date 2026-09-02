<?php
include("../inc/conn.php");

if(isset($_POST['name']) && $_POST['name']!=''){
	$name=mysqli_real_escape_string($con,$_POST['name']);
	$slug=strtolower($name);
	$slug=str_replace(" ","-",$slug);
	$slug=str_replace("'","",$slug);
	$slug=str_replace("?","",$slug);
	$slug=str_replace(",","",$slug);
	$slug=str_replace(".","",$slug);
	$slug=str_replace(";","",$slug);
	$slug=str_replace(":","",$slug);
	$slug=str_replace("(","",$slug);
	$slug=str_replace(")","",$slug);
	$slug=str_replace("}","",$slug);
	$slug=str_replace("{","",$slug);
	$slug=str_replace("[","",$slug);
	$slug=str_replace("]","",$slug);

	$res=mysqli_query($con,"select * from product where slug='$slug'");
	if(mysqli_num_rows($res)>0){
		$res=mysqli_query($con,"select max(id) as id from product");
		$row=mysqli_fetch_assoc($res);
		$id=$row['id'];
		$id++;
		$slug=$slug.'-'.$id;
	}
	echo $slug;
}

?>