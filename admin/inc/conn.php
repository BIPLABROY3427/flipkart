<?php
session_set_cookie_params(2592000); // 30 days
session_start();
$domin=$_SERVER['SERVER_NAME'];
$servername = "localhost";
$username = "root";
$password = "";
$database = "flipkart";
// Create connection
$con =  mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set("Asia/Kolkata");
define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
define('REDIRECT_PATH', $protocol.$domin.'/');
define('SITE_PATH', $protocol.$domin.'/');


define('PROFILE_PATH',SITE_PATH.'admin/uploads/profile/');
define('LOGO_PATH',SITE_PATH.'admin/uploads/logo/');
define('PRODUCT_PATH',SITE_PATH.'admin/uploads/product/');
define('BANNER_PATH',SITE_PATH.'admin/uploads/banner/');

?>
