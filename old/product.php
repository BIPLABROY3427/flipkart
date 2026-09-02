<?php 
    include('inc/function.php'); 
    if(isset($_GET["product"]) == true ){
        if(check_product($con,$_GET["product"])==true){
            $product_id= mysqli_fetch_array($con->query("select * from product WHERE slug='".$_GET["product"]."'"));
		    $product=get_product($con,$product_id['id']);
            $get_gallery=get_gallery($con,$product[0]['id']);
            $get_color=get_color($con,$product[0]['id']);
            $get_attributes=get_attributes($con,$product[0]['id']);
	    
?>
<!DOCTYPE html>
<html lang="en-IN">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <title>We are Here to help you, Electronics, Furniture, Grocery, Lifestyle, Books &amp; More. Exclusive Offers!</title>
    <link rel="icon" type="image/x-icon" href="<?php echo SITE_PATH ?>assets/img/favicon.png">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Keywords" content="Online Shopping in India,online Shopping store,Online Shopping Site,Buy Online,Shop Online,Fliipkart">
    <meta name="Description" content="India&#39;s biggest online store for Mobiles, Fashion (Clothes/Shoes), Electronics, Home Appliances, Books, Jewelry, Home, Furniture, Sporting goods, Beauty &amp; Personal Care, Grocery and more! Find the largest selection from all brands at the lowest prices in India. Payment options - COD, EMI, Credit card, Debit card &amp; more.">
    <meta property="og:title" content="We are Here To Help You">
    <meta name="theme-color" content="#2874f0" id="themeColor">
    <meta name="viewport" content="width=device-width,minimum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SITE_PATH ?>assets/css/custom.css">
    <script> var MAIN_URL = '<?php echo SITE_PATH ?>'; </script>
</head>

<body class="expansion-alids-init" cz-shortcut-listen="true">
    <div id="container" style="overflow:hidden">
        <div style="height:100%" data-reactroot="">
            <div class="container-fluid py-2 header-container" style="background-color:#2874f0">
                <div class="row header">
                    <div class="col-1">
                        <div class="menu-icon" id="back_btn">
                            <svg width="19" height="16" viewBox="0 0 19 16" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.556 7.847H1M7.45 1L1 7.877l6.45 6.817" stroke="#FFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"></path>
                            </svg> 
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="menu-logo">
                            <img alt="menu" src="<?php echo SITE_PATH ?>img/Q18Ifxk.png" class="lozad" height="30px">
                        </div>
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col-1">
                        <div class="menu-icon">
                            <svg width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g fill="#FFF" fill-rule="evenodd"><path d="m11.618 9.897l4.225 4.212c.092.092.101.232.02.313l-1.465 1.46c-.081.081-.221.072-.314-.02l-4.216-4.203"/><path d="m6.486 10.901c-2.42 0-4.381-1.956-4.381-4.368 0-2.413 1.961-4.369 4.381-4.369 2.42 0 4.381 1.956 4.381 4.369 0 2.413-1.961 4.368-4.381 4.368m0-10.835c-3.582 0-6.486 2.895-6.486 6.467 0 3.572 2.904 6.467 6.486 6.467 3.582 0 6.486-2.895 6.486-6.467 0-3.572-2.904-6.467-6.486-6.467"/></g></svg>                            </div>
                    </div>
                    <div class="col-1">
                        <div class="menu-icon">
                            <svg width="16" height="16" viewBox="0 0 15 15" xmlns="external452e452e452e452e.html?link=http://www.w3.org/2000/svg">
                                <g fill="#fff" fill-rule="evenodd">
                                    <path d="m5.189 13.04c0 .996-.791 1.804-1.767 1.804-.976 0-1.767-.808-1.767-1.804 0-.996.791-1.804 1.767-1.804.976 0 1.767.808 1.767 1.804"></path>
                                    <path d="m14.912 2.259h-14.298l2.247 6.917c.042.129.16.216.293.216h8.06c-.064.69-.629 1.841-1.702 1.841h-6.04l1.072 1.991h5.611c1.881 0 2.938-2.278 3.657-4.719.888-3.01 1.219-6.245 1.106-6.245"></path>
                                    <path d="m.615 2.259l-.592-1.828c-.08-.207.069-.431.287-.431h1.482c.126 0 .24.079.287.198l.682 2.061c0 0-.63 1.642-1.942.066"></path>
                                    <path d="m2.262.756c0 0 .498 1.503 2.234 1.503l-1.736.749-1.104-.749.607-1.503"></path>
                                    <path d="m13.424 13.325c0 .837-.664 1.516-1.484 1.516-.82 0-1.484-.679-1.484-1.516 0-.837.664-1.516 1.484-1.516.82 0 1.484.679 1.484 1.516"></path>
                                </g>
                            </svg> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="_1fhgRH mb-5">
                <div class="container p-1 card">
                    <div class="container-fluid px-0 product-slider">
                        <div class="love-icon"></div>
                        <div class="share-icon"></div>
                        <div id="sliderX" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-bs-target="#sliderX" data-bs-slide-to="0" class="active"></li>
                                <?php foreach($get_gallery as $gallery){ ?>
                                <li data-bs-target="#sliderX" data-bs-slide-to="2" class=""></li>
                                <?php } ?>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block img-fluid m-auto lozad" style="height: 400px;" src="<?php echo PRODUCT_PATH.$product[0]['image']; ?>">
                                </div>
                                <?php foreach($get_gallery as $gallery){ ?>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid m-auto lozad" style="height: 400px;" src="<?php echo PRODUCT_PATH.$gallery['product_images']; ?>">
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php if(!empty($get_color[0]['color'])){ ?>
                        <div class="color-div">
                            <h4>Select Color</h4>
                            <div class="color-list p-2">
                                <?php $i=0; foreach($get_color as $color){ $i++; ?>
                                <div class="color-item p-2 me-2 <?php echo str_replace("/","_",str_replace(" ","_",$color['color'])); ?>  <?php if($i=='1'){ echo 'active'; } ?>" <?php if($i=='1'){ echo 'id="autoClickBtn"'; } ?> onclick="manage_color_click('<?php echo $color['color']; ?>');">
                                    <img src="<?php echo PRODUCT_PATH.$color['product_images']; ?>" class="lozad"alt="img0">
                                    <span class="color-name"><?php echo $color['color']; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($get_attributes[0]['storage'])){ ?>
                        <div class="storage-div mt-3">
                            <h4>Select Storage</h4>
                            <div class="storage-list p-2">
                                <?php $ii=0; foreach($get_attributes as $attributes){ $ii++; ?>
                                <div class="storage-item p-2 me-2 <?php echo str_replace(" ","_",$attributes['storage']); ?>  <?php if($ii=='1'){ echo 'active'; } ?>" <?php if($ii=='1'){ echo 'id="autoClickBtn1"'; } ?> onclick="manage_storage_click('<?php echo $attributes['storage']; ?>');">
                                    <span class="storage-name"><?php echo $attributes['storage']; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(!empty($get_attributes[0]['size'])){ ?>
                        <div class="size-div mt-3" >
                            <h4>Select Size</h4>
                            <div class="size-list p-2">
                                <?php $ii=0; foreach($get_attributes as $attributes){ $ii++; ?>
                                <div class="size-item p-2 me-2  <?php echo str_replace("-","_",str_replace(" ","_",$attributes['size'])); ?>  <?php if($ii=='1'){ echo 'active'; } ?>" <?php if($ii=='1'){ echo 'id="autoClickBtn1"'; } ?> onclick="manage_size_click('<?php echo $attributes['size']; ?>');">
                                    <span class="size-name"><?php echo $attributes['size']; ?></span>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="container-fluid p-3 mt-1 card">
                    <div class="product-title"><?php echo $product[0]['name']; ?></div>
                    <img style="width: 100px" class="my-2 lozad" src="<?php echo SITE_PATH ?>img/plue-fassured.png" alt="plue-fassured">
                    <div class="product-price d-flex my-2">
                        <span class="discount"><?php echo cal_percentage($product[0]['price'],$product[0]['mrp']); ?>% off</span>
                        <span class="mrp" id="mrp" ><?php echo '₹ '.number_format($product[0]['mrp'], 2, '.', ','); ?></span>
                        <span class="price" id="price"><?php echo '₹ '.number_format($product[0]['price'], 2, '.', ','); ?></span>
                    </div>
                </div>
                <div class="container-fluid p-3 offerend-container card">
                    <h4 class="m-0"> Offer ends in <span class="offer-timer" id="offerend-time"></span>
                </div>
                <div class="container-fluid p-3 mb-1 card">
                    <img class="my-2 lozad" src="<?php echo SITE_PATH ?>img/pay-latter.png" alt="pay-latter">
                </div>
                <div class="container-fluid px-2 py-3 d-flex feature-container product-extra card">
                    <div class="col-4 featured-item d-flex align-items-center flex-column bd-highlight px-1">
                        <img class="featured-img mb-3 lozad" src="<?php echo SITE_PATH ?>img/replacement.png" />
                        <span class="feature-title"> 7 days Replacement </span>
                    </div>
                    <div class="col-4 featured-item d-flex align-items-center flex-column bd-highlight px-1">
                        <img class="featured-img mb-3 lozad" src="<?php echo SITE_PATH ?>img/non-cod.png" />
                        <span class="feature-title"> No Cash On Delivery </span>
                    </div>
                    <div class="col-4 featured-item d-flex align-items-center flex-column bd-highlight px-1">
                        <img class="featured-img mb-3 mt-1 lozad" src="<?php echo SITE_PATH ?>img/plue-fassured.png" />
                        <span class="feature-title"> Plus (F-Assured) </span>
                    </div>
                </div>
                <div class="container-fluid product-detail px-0 py-3 mb-4 card">
                    <div class="product-details">
                         <?php 
                            $g_qry= mysqli_query($con,"SELECT * FROM product_dsc WHERE product_id='".$product[0]['id']."' ORDER BY id ASC");
                            while($dsc= mysqli_fetch_array($g_qry)){
                                echo "<img width='100%'class='lozad' src='".PRODUCT_PATH.$dsc['product_images']."'>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="button-container flex">
                <button class="buynow-button buynow-button-white product-page-buy" onclick="buyNow(title='<?php echo $product[0]['name']; ?>',price='<?php echo $product[0]['price']; ?>',mrp='<?php echo $product[0]['mrp']; ?>',image='<?php echo PRODUCT_PATH.$product[0]['image']; ?>');"> Add to Cart </button>
                <button class="buynow-button product-page-buy" onclick="buyNow(title='<?php echo $product[0]['name']; ?>',price='<?php echo $product[0]['price']; ?>',mrp='<?php echo $product[0]['mrp']; ?>',image='<?php echo PRODUCT_PATH.$product[0]['image']; ?>');"> Buy Now </button>
            </div>

        </div>
        <footer class="seofooter" id="seofooter">
        </footer>
        <script defer src="<?php echo SITE_PATH ?>assets/js/jquery.min.js"></script>
        <script defer src="<?php echo SITE_PATH ?>assets/js/bootstrap.min.js"></script>
        <script defer src="<?php echo SITE_PATH ?>assets/js/relativeTime.js"></script>
        <script defer src="<?php echo SITE_PATH ?>assets/js/days.min.js"></script>
        <script defer src="<?php echo SITE_PATH ?>assets/js/custom.js"></script>
        <script defer src="<?php echo SITE_PATH ?>assets/js/manage_product.js"></script>
</body>

</html>
<?php
}else{
    echo "<script type='text/javascript'>history.back();</script>";
}
}else{
echo "<script type='text/javascript'>history.back();</script>";
}
?>