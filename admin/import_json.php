<?php
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '80';
include('inc/conn.php');

$json_data = file_get_contents(__DIR__ . '/../product_schema.json');
$data = json_decode($json_data, true);

if (!$data || !isset($data['product'])) {
    die("Invalid JSON data");
}

$p = $data['product'];

// Insert into product table
$name = mysqli_real_escape_string($con, $p['name']);
$slug = mysqli_real_escape_string($con, $p['slug']);
$mrp = (float)$p['mrp'];
$price = (float)$p['price'];
$main_image = mysqli_real_escape_string($con, $p['main_image']);
$trust_strip_image = mysqli_real_escape_string($con, $p['trust_strip_image']);
$extra_desc_image = isset($p['extra_desc_image']) ? mysqli_real_escape_string($con, $p['extra_desc_image']) : '';
$rating = (float)$p['rating'];
$reviews = (int)$p['reviews'];
$cat_id = (int)$p['category_id'];
$brand_id = (int)$p['brand_id'];

$rb = $p['rating_breakdown'];
$sd = $p['seller_details'];

$seller_name = mysqli_real_escape_string($con, $sd['seller_name']);
$seller_rating = mysqli_real_escape_string($con, $sd['seller_rating']);
$seller_years = (int)$sd['seller_years'];

$sql_product = "INSERT INTO product 
    (`name`, `slug`, `mrp`, `price`, `image`, `trust_strip_image`, `extra_desc_image`, `rating`, `reviews`, 
     `star_5`, `star_4`, `star_3`, `star_2`, `star_1`, 
     `seller_name`, `seller_rating`, `seller_years`, `category_id`, `brand_id`, `status`) 
    VALUES 
    ('$name', '$slug', $mrp, $price, '$main_image', '$trust_strip_image', '$extra_desc_image', $rating, $reviews, 
     ".(int)$rb['star_5'].", ".(int)$rb['star_4'].", ".(int)$rb['star_3'].", ".(int)$rb['star_2'].", ".(int)$rb['star_1'].",
     '$seller_name', '$seller_rating', $seller_years, $cat_id, $brand_id, 1)";

if(mysqli_query($con, $sql_product)) {
    $product_id = mysqli_insert_id($con);
    echo "Product inserted with ID: $product_id\n";
    
    // Insert color variants and gallery images
    if(isset($p['color_variants']) && is_array($p['color_variants'])) {
        foreach($p['color_variants'] as $cv) {
            $color = mysqli_real_escape_string($con, $cv['color']);
            $p_image = mysqli_real_escape_string($con, $cv['product_images']);
            $sql_color = "INSERT INTO product_color (`product_id`, `product_images`, `color`, `link`) VALUES ($product_id, '$p_image', '$color', '')";
            if(mysqli_query($con, $sql_color)) {
                $color_id = mysqli_insert_id($con);
                if(isset($cv['gallery_images']) && is_array($cv['gallery_images'])) {
                    foreach($cv['gallery_images'] as $gimg) {
                        $gimg_esc = mysqli_real_escape_string($con, $gimg);
                        mysqli_query($con, "INSERT INTO product_color_gallery (`color_id`, `image`) VALUES ($color_id, '$gimg_esc')");
                    }
                }
            }
        }
    }
    
    // Insert description images
    if(isset($p['desc_images']) && is_array($p['desc_images'])) {
        foreach($p['desc_images'] as $dimg) {
            $dimg_esc = mysqli_real_escape_string($con, $dimg);
            mysqli_query($con, "INSERT INTO product_dsc (`product_id`, `product_images`) VALUES ($product_id, '$dimg_esc')");
        }
    }
    
    // Insert reviews
    if(isset($p['user_reviews']) && is_array($p['user_reviews'])) {
        foreach($p['user_reviews'] as $rev) {
            $r_name = mysqli_real_escape_string($con, $rev['name']);
            $r_loc = mysqli_real_escape_string($con, $rev['location']);
            $r_time = mysqli_real_escape_string($con, $rev['time_ago']);
            $r_rating = (float)$rev['rating'];
            $r_title = mysqli_real_escape_string($con, $rev['title']);
            $r_text = mysqli_real_escape_string($con, $rev['review_text']);
            
            $r_img = '';
            if(isset($rev['images']) && is_array($rev['images'])) {
                $r_img = mysqli_real_escape_string($con, implode(',', $rev['images']));
            }
            
            mysqli_query($con, "INSERT INTO product_reviews (`product_id`, `name`, `location`, `time_ago`, `rating`, `title`, `review_text`, `image`) VALUES ($product_id, '$r_name', '$r_loc', '$r_time', $r_rating, '$r_title', '$r_text', '$r_img')");
        }
    }
    
    echo "Import Successful!\n";
} else {
    echo "Error inserting product: " . mysqli_error($con) . "\n";
}
?>
