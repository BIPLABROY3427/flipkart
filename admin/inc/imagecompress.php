<?php
function compressImage($source, $destination, $quality) { 
    // Get image info 
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            imagejpeg($image, $destination, $quality);
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source);
            imageAlphaBlending($image, true);
            imageSaveAlpha($image, true);
            $pngQuality = round(9 - ($quality * 9 / 100)); // convert 0-100 to 9-0
            imagepng($image, $destination, $pngQuality);
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            imagegif($image, $destination);
            break; 
        case 'image/webp':
            $image = imagecreatefromwebp($source);
            imagewebp($image, $destination, $quality);
            break;
        default: 
            $image = imagecreatefromjpeg($source); 
            imagejpeg($image, $destination, $quality);
            break;
    } 
     
    imagedestroy($image);
     
    // Return compressed image 
    return $destination; 
}
?>