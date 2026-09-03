<?php
include('../inc/conn.php');
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    // Fetch the image filename to delete the file
    $res = mysqli_query($con, "SELECT image FROM product_color_gallery WHERE id='$id'");
    if ($row = mysqli_fetch_assoc($res)) {
        $filename = $row['image'];
        $filepath = '../../uploads/product/' . $filename;
        if (file_exists($filepath) && !empty($filename)) {
            unlink($filepath);
        }
    }
    // Delete from DB
    mysqli_query($con, "DELETE FROM product_color_gallery WHERE id='$id'");
    echo 'success';
}
?>
