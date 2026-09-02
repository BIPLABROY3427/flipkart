<?php
session_start();
$domin=$_SERVER['SERVER_NAME'];
$servername = "localhost";
$username = "flipkart";
$password = "flipkart";
$database = "flipkart";
// Create connection
$con =  mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set("Asia/Kolkata");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'');
define('REDIRECT_PATH','https://'.$domin.'/');
define('SITE_PATH','https://'.$domin.'/');


define('PROFILE_PATH',SITE_PATH.'admin/uploads/profile/');
define('LOGO_PATH',SITE_PATH.'admin/uploads/logo/');
define('PRODUCT_PATH',SITE_PATH.'admin/uploads/product/');
define('BANNER_PATH',SITE_PATH.'admin/uploads/banner/');

?> 