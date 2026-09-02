<?php
include('inc/function.php');
$con = mysqli_connect("localhost","root","","flipkart");
$grid_products = get_product($con, array('category_id' => 1));
echo count($grid_products);
?>
