<?php
include('../inc/conn.php');

$id = $_REQUEST['id'];

// Get image and delete file
$res = mysqli_query($con, "SELECT image FROM product_reviews WHERE id='$id'");
if($row = mysqli_fetch_assoc($res)) {
    if(!empty($row['image']) && file_exists("../../uploads/product/" . $row['image'])) {
        unlink("../../uploads/product/" . $row['image']);
    }
}

// Delete record
mysqli_query($con, "DELETE FROM product_reviews WHERE id='$id'");
echo "Success";
?>
