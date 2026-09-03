
<?php
    include('../inc/conn.php');
    include('../inc/imagecompress.php');
    $date=date("Y-m-d h:i:s");
    if($_REQUEST['page']=='Product-Item-Add'){
        $res=mysqli_query($con,"select * from product where slug='".$_REQUEST['slug']."'");
        if(mysqli_num_rows($res)>0){
            $jsonArr=array('statusCode'=>'201','status'=>'info','message'=>'This slug is already Added');
        }else{
            $location = '../uploads/product/';
            if(!empty($_FILES['img']['name'])){
                $location = '../uploads/product/';
                $time_profile = 'product-'.date("d-m-Y")."-".time() ;
                $a1 = [".jpg", ".png", ".jpeg"];
                $a2   = [".webp",".webp",".webp"];
                $profile = str_replace($a1,$a2,basename($_FILES["img"]["name"]));
                $file_profile = $time_profile."-".$profile;
                $targetFile_profile = $location . $file_profile;
                $imageSize = $_FILES["img"]["size"];
                if($imageSize<500000){
                    move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile_profile);
                }else{
                    $imageTemp = $_FILES["img"]["tmp_name"]; 
                    $imageUploadPath = $location . $file_profile;
                    $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                }
                
            }else{
                $file_profile='';
            }
            if(!empty($_FILES['trust_strip_image']['name'])){
                $location = '../uploads/product/';
                $time_profile = 'trust-'.date("d-m-Y")."-".time() ;
                $a1 = [".jpg", ".png", ".jpeg"];
                $a2   = [".webp",".webp",".webp"];
                $profile = str_replace($a1,$a2,basename($_FILES["trust_strip_image"]["name"]));
                $file_trust = $time_profile."-".$profile;
                $targetFile_profile = $location . $file_trust;
                $imageSize = $_FILES["trust_strip_image"]["size"];
                if($imageSize<500000){
                    move_uploaded_file($_FILES["trust_strip_image"]["tmp_name"], $targetFile_profile);
                }else{
                    $imageTemp = $_FILES["trust_strip_image"]["tmp_name"]; 
                    $imageUploadPath = $location . $file_trust;
                    $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                }
            }else{
                $file_trust='';
            }
            $sql_insert = "insert into product set `image` = '".$file_profile."', `trust_strip_image` = '".$file_trust."', name = '".str_replace("'", "\'", $_REQUEST['name'])."',slug = '".$_REQUEST['slug']."',mrp = '".$_REQUEST['mrp']."',price = '".$_REQUEST['price']."', rating = '".(float)$_REQUEST['rating']."', reviews = '".(int)$_REQUEST['reviews']."', star_5 = '".(int)$_REQUEST['star_5']."', star_4 = '".(int)$_REQUEST['star_4']."', star_3 = '".(int)$_REQUEST['star_3']."', star_2 = '".(int)$_REQUEST['star_2']."', star_1 = '".(int)$_REQUEST['star_1']."', seller_name = '".str_replace("'", "\'", $_REQUEST['seller_name'])."', seller_rating = '".str_replace("'", "\'", $_REQUEST['seller_rating'])."', seller_years = '".(int)$_REQUEST['seller_years']."',   category_id = '".(int)$_REQUEST['category_id']."', brand_id = '".(int)$_REQUEST['brand_id']."', status = '1'"; 
            $query_insert = mysqli_query($con, $sql_insert);
            $store_id=mysqli_insert_id($con);
                
            if($query_insert){
                
            if(isset($_POST['rev_name'])){
                foreach($_POST['rev_name'] as $id=>$val){
                    if(!empty($_POST['rev_name'][$id]) && !empty($_POST['rev_title'][$id])){
                        $r_name = str_replace("'", "'", $_POST['rev_name'][$id]);
                        $r_loc = str_replace("'", "'", $_POST['rev_location'][$id]);
                        $r_time = str_replace("'", "'", $_POST['rev_time'][$id]);
                        $r_rate = (int)$_POST['rev_rating'][$id];
                        $r_title = str_replace("'", "'", $_POST['rev_title'][$id]);
                        $r_text = str_replace("'", "'", $_POST['rev_text'][$id]);
                        $r_image = '';
                        
                        if(isset($_FILES['rev_image']['name'][$id]) && !empty($_FILES['rev_image']['name'][$id])){
                            $a1 = [".jpg", ".png", ".jpeg"];
                            $a2   = [".webp",".webp",".webp"];
                            $fileName = str_replace($a1,$a2,'Review-'.date("d-m-Y")."-".time().$_FILES['rev_image']['name'][$id]);
                            $tempLocation = $_FILES['rev_image']['tmp_name'][$id];
                            $targetFilePath = $location . $fileName;
                            $imageSize = $_FILES["rev_image"]["size"][$id];
                            if($imageSize<500000){
                                move_uploaded_file($tempLocation, $targetFilePath);
                            }else{
                                $compressedImage = compressImage($tempLocation, $targetFilePath, 75);
                            }
                            $r_image = $fileName;
                        }
                        
                        $sqlVal = "('".$store_id."', '".$r_name."', '".$r_loc."', '".$r_time."', '".$r_rate."', '".$r_title."', '".$r_text."', '".$r_image."')";
                        $con->query("INSERT INTO `product_reviews` (`product_id`, `name`, `location`, `time_ago`, `rating`, `title`, `review_text`, `image`) VALUES $sqlVal");
                    }
                }
            }

            
            if(isset($_POST['rev_name'])){
                foreach($_POST['rev_name'] as $id=>$val){
                    if(!empty($_POST['rev_name'][$id]) && !empty($_POST['rev_title'][$id])){
                        $r_name = str_replace("'", "'", $_POST['rev_name'][$id]);
                        $r_loc = str_replace("'", "'", $_POST['rev_location'][$id]);
                        $r_time = str_replace("'", "'", $_POST['rev_time'][$id]);
                        $r_rate = (int)$_POST['rev_rating'][$id];
                        $r_title = str_replace("'", "'", $_POST['rev_title'][$id]);
                        $r_text = str_replace("'", "'", $_POST['rev_text'][$id]);
                        $r_image = '';
                        
                        if(isset($_FILES['rev_image']['name'][$id]) && !empty($_FILES['rev_image']['name'][$id])){
                            $a1 = [".jpg", ".png", ".jpeg"];
                            $a2   = [".webp",".webp",".webp"];
                            $fileName = str_replace($a1,$a2,'Review-'.date("d-m-Y")."-".time().$_FILES['rev_image']['name'][$id]);
                            $tempLocation = $_FILES['rev_image']['tmp_name'][$id];
                            $targetFilePath = $location . $fileName;
                            $imageSize = $_FILES["rev_image"]["size"][$id];
                            if($imageSize<500000){
                                move_uploaded_file($tempLocation, $targetFilePath);
                            }else{
                                $compressedImage = compressImage($tempLocation, $targetFilePath, 75);
                            }
                            $r_image = $fileName;
                        }
                        
                        $sqlVal = "('".$store_id."', '".$r_name."', '".$r_loc."', '".$r_time."', '".$r_rate."', '".$r_title."', '".$r_text."', '".$r_image."')";
                        $con->query("INSERT INTO `product_reviews` (`product_id`, `name`, `location`, `time_ago`, `rating`, `title`, `review_text`, `image`) VALUES $sqlVal");
                    }
                }
            }

            if(isset($_FILES['gallery']['name'])){
                    foreach($_FILES['gallery']['name'] as $id=>$val){
                        
                    $a1 = [".jpg", ".png", ".jpeg"];
                    $a2   = [".webp",".webp",".webp"];
                        $fileName        = str_replace($a1,$a2,'Gallery-'.date("d-m-Y")."-".time().$_FILES['gallery']['name'][$id]);
                        $tempLocation    = $_FILES['gallery']['tmp_name'][$id];
                        $targetFilePath  = $location . $fileName;
                        $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                        // move_uploaded_file($tempLocation, $targetFilePath);
                        $imageSize = $_FILES["gallery"]["size"][$id];
                        if($imageSize<500000){
                            move_uploaded_file($tempLocation, $targetFilePath);
                        }else{
                            $imageTemp = $_FILES["gallery"]["tmp_name"][$id]; 
                            $imageUploadPath = $location . $fileName;
                            $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                        }
                        $sqlVal = "('".$store_id."', '".$fileName."')";
                        if(!empty($fileName)) {
                            $insert = $con->query("INSERT INTO `product_images` (`product_id`, `product_images`) VALUES $sqlVal");
                        }
                    }
                }
                if(isset($_FILES['gallery1']['name'])){
                    foreach($_FILES['gallery1']['name'] as $id=>$val){
                        $color=$_REQUEST['color'][$id];
                        
                    $a1 = [".jpg", ".png", ".jpeg"];
                    $a2   = [".webp",".webp",".webp"];
                        $fileName        = str_replace($a1,$a2,'Color-'.date("d-m-Y")."-".time().$_FILES['gallery1']['name'][$id]);
                        $tempLocation    = $_FILES['gallery1']['tmp_name'][$id];
                        $targetFilePath  = $location . $fileName;
                        $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                        // move_uploaded_file($tempLocation, $targetFilePath);
                        $imageSize = $_FILES["gallery1"]["size"][$id];
                        if($imageSize<500000){
                            move_uploaded_file($tempLocation, $targetFilePath);
                        }else{
                            $imageTemp = $_FILES["gallery1"]["tmp_name"][$id]; 
                            $imageUploadPath = $location . $fileName;
                            $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                        }
                        $sqlVal = "('".$store_id."', '".$fileName."','".$color."','".$color_link."')";
                        if(!empty($fileName)) {
                            $insert = $con->query("INSERT INTO `product_color` (`product_id`, `product_images`, `color`, `link`) VALUES $sqlVal");
                            if($insert) {
                                $color_id = $con->insert_id;
                                if(isset($_FILES['color_gallery']['name'][$id]) && is_array($_FILES['color_gallery']['name'][$id])) {
                                    foreach($_FILES['color_gallery']['name'][$id] as $cg_idx => $cg_val) {
                                        if(!empty($cg_val)) {
                                            $cg_fileName = str_replace($a1,$a2,'CG-'.date("d-m-Y")."-".time().$cg_val);
                                            $cg_tempLocation = $_FILES['color_gallery']['tmp_name'][$id][$cg_idx];
                                            $cg_targetFilePath = $location . $cg_fileName;
                                            move_uploaded_file($cg_tempLocation, $cg_targetFilePath);
                                            $con->query("INSERT INTO `product_color_gallery` (`color_id`, `image`) VALUES ('".$color_id."', '".$cg_fileName."')");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if(isset($_FILES['dsc']['name'])){
                    foreach($_FILES['dsc']['name'] as $id=>$val){
                        
                    $a1 = [".jpg", ".png", ".jpeg"];
                    $a2   = [".webp",".webp",".webp"];
                        $fileName        = str_replace($a1,$a2,'Dsc-'.date("d-m-Y")."-".time().$_FILES['dsc']['name'][$id]);
                        $tempLocation    = $_FILES['dsc']['tmp_name'][$id];
                        $targetFilePath  = $location . $fileName;
                        $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                        // move_uploaded_file($tempLocation, $targetFilePath);
                        $imageSize = $_FILES["dsc"]["size"][$id];
                        if($imageSize<500000){
                            move_uploaded_file($tempLocation, $targetFilePath);
                        }else{
                            $imageTemp = $_FILES["dsc"]["tmp_name"][$id]; 
                            $imageUploadPath = $location . $fileName;
                            $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                        }
                        $sqlVal = "('".$store_id."', '".$fileName."')";
                        if(!empty($fileName)) {
                            $insert = $con->query("INSERT INTO `product_dsc` (`product_id`, `product_images`) VALUES $sqlVal");
                        }
                    }
                }
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'New Product Added');
            }else{
                $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
            }
        } 
    }
    if($_REQUEST['page']=='Product-Item-Edit'){
        $res=mysqli_query($con,"select * from product where slug='".$_REQUEST['slug']."' AND id!='".$_REQUEST['id']."'");
        if(mysqli_num_rows($res)>0){
            $jsonArr=array('statusCode'=>'201','status'=>'info','message'=>'This slug is already Added');
        }else{
            $location = '../uploads/product/';
            if(!empty($_FILES['img']['name'])){
                $location = '../uploads/product/';
                $time_profile = 'product-'.date("d-m-Y")."-".time() ;
                $a1 = [".jpg", ".png", ".jpeg"];
                $a2   = [".webp",".webp",".webp"];
                $profile = str_replace($a1,$a2,basename($_FILES["img"]["name"]));
                $file_profile = $time_profile."-".$profile;
                $targetFile_profile = $location . $file_profile;
                move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile_profile);
                $imageSize = $_FILES["img"]["size"];
                if($imageSize<500000){
                    move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile_profile);
                }else{
                    $imageTemp = $_FILES["img"]["tmp_name"]; 
                    $imageUploadPath = $location . $file_profile;
                    $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                }
                $sql_insert1 = mysqli_query($con, "UPDATE product set `image` = '".$file_profile."' WHERE id='".$_REQUEST['id']."'");
            }
            if(!empty($_FILES['trust_strip_image']['name'])){
                $location = '../uploads/product/';
                $time_profile = 'trust-'.date("d-m-Y")."-".time() ;
                $a1 = [".jpg", ".png", ".jpeg"];
                $a2   = [".webp",".webp",".webp"];
                $profile = str_replace($a1,$a2,basename($_FILES["trust_strip_image"]["name"]));
                $file_trust = $time_profile."-".$profile;
                $targetFile_profile = $location . $file_trust;
                $imageSize = $_FILES["trust_strip_image"]["size"];
                if($imageSize<500000){
                    move_uploaded_file($_FILES["trust_strip_image"]["tmp_name"], $targetFile_profile);
                }else{
                    $imageTemp = $_FILES["trust_strip_image"]["tmp_name"]; 
                    $imageUploadPath = $location . $file_trust;
                    $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                }
                $sql_insert2 = mysqli_query($con, "UPDATE product set `trust_strip_image` = '".$file_trust."' WHERE id='".$_REQUEST['id']."'");
            }
            $sql_insert = "UPDATE product set name = '".str_replace("'", "\'", $_REQUEST['name'])."',slug = '".$_REQUEST['slug']."',mrp = '".$_REQUEST['mrp']."',price = '".$_REQUEST['price']."' , rating = '".(float)$_REQUEST['rating']."', reviews = '".(int)$_REQUEST['reviews']."', star_5 = '".(int)$_REQUEST['star_5']."', star_4 = '".(int)$_REQUEST['star_4']."', star_3 = '".(int)$_REQUEST['star_3']."', star_2 = '".(int)$_REQUEST['star_2']."', star_1 = '".(int)$_REQUEST['star_1']."', seller_name = '".str_replace("'", "\'", $_REQUEST['seller_name'])."', seller_rating = '".str_replace("'", "\'", $_REQUEST['seller_rating'])."', seller_years = '".(int)$_REQUEST['seller_years']."', category_id = '".(int)$_REQUEST['category_id']."', brand_id = '".(int)$_REQUEST['brand_id']."' WHERE id='".$_REQUEST['id']."'"; 
            $query_insert = mysqli_query($con, $sql_insert);
            
            if(isset($_POST['rev_name'])){
                foreach($_POST['rev_name'] as $id=>$val){
                    if(!empty($_POST['rev_name'][$id]) && !empty($_POST['rev_title'][$id])){
                        $r_name = str_replace("'", "'", $_POST['rev_name'][$id]);
                        $r_loc = str_replace("'", "'", $_POST['rev_location'][$id]);
                        $r_time = str_replace("'", "'", $_POST['rev_time'][$id]);
                        $r_rate = (int)$_POST['rev_rating'][$id];
                        $r_title = str_replace("'", "'", $_POST['rev_title'][$id]);
                        $r_text = str_replace("'", "'", $_POST['rev_text'][$id]);
                        $r_image = '';
                        
                        if(isset($_FILES['rev_image']['name'][$id]) && !empty($_FILES['rev_image']['name'][$id])){
                            $a1 = [".jpg", ".png", ".jpeg"];
                            $a2   = [".webp",".webp",".webp"];
                            $fileName = str_replace($a1,$a2,'Review-'.date("d-m-Y")."-".time().$_FILES['rev_image']['name'][$id]);
                            $tempLocation = $_FILES['rev_image']['tmp_name'][$id];
                            $targetFilePath = $location . $fileName;
                            $imageSize = $_FILES["rev_image"]["size"][$id];
                            if($imageSize<500000){
                                move_uploaded_file($tempLocation, $targetFilePath);
                            }else{
                                $compressedImage = compressImage($tempLocation, $targetFilePath, 75);
                            }
                            $r_image = $fileName;
                        }
                        
                        $sqlVal = "('".$store_id."', '".$r_name."', '".$r_loc."', '".$r_time."', '".$r_rate."', '".$r_title."', '".$r_text."', '".$r_image."')";
                        $con->query("INSERT INTO `product_reviews` (`product_id`, `name`, `location`, `time_ago`, `rating`, `title`, `review_text`, `image`) VALUES $sqlVal");
                    }
                }
            }

            if(isset($_FILES['gallery']['name'])){
                foreach($_FILES['gallery']['name'] as $id=>$val){
                    
                    $a1 = [".jpg", ".png", ".jpeg"];
                    $a2   = [".webp",".webp",".webp"];
                    $fileName        = str_replace($a1,$a2,'Gallery-'.date("d-m-Y")."-".time().$_FILES['gallery']['name'][$id]);
                    $tempLocation    = $_FILES['gallery']['tmp_name'][$id];
                    $targetFilePath  = $location . $fileName;
                    $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                    // move_uploaded_file($tempLocation, $targetFilePath);
                    $imageSize = $_FILES["gallery"]["size"][$id];
                    if($imageSize<500000){
                        move_uploaded_file($tempLocation, $targetFilePath);
                    }else{
                        $imageTemp = $_FILES["gallery"]["tmp_name"][$id]; 
                        $imageUploadPath = $location . $fileName;
                        $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                    }
                    $sqlVal = "('".$_REQUEST['id']."', '".$fileName."')";
                    if(!empty($fileName)) {
                        $insert = $con->query("INSERT INTO `product_images` (`product_id`, `product_images`) VALUES $sqlVal");
                    }
                }
            }
            if(isset($_FILES['gallery1']['name'])){
                foreach($_FILES['gallery1']['name'] as $id=>$val){
                    $color=$_REQUEST['color'][$id];
                    
                    $a1 = [".jpg", ".png", ".jpeg"];
                    $a2   = [".webp",".webp",".webp"];
                    $fileName        = str_replace($a1,$a2,'Color-'.date("d-m-Y")."-".time().$_FILES['gallery1']['name'][$id]);
                    $tempLocation    = $_FILES['gallery1']['tmp_name'][$id];
                    $targetFilePath  = $location . $fileName;
                    $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                    // move_uploaded_file($tempLocation, $targetFilePath);
                    $imageSize = $_FILES["gallery1"]["size"][$id];
                    if($imageSize<500000){
                        move_uploaded_file($tempLocation, $targetFilePath);
                    }else{
                        $imageTemp = $_FILES["gallery1"]["tmp_name"][$id]; 
                        $imageUploadPath = $location . $fileName;
                        $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                    }
                    $sqlVal = "('".$_REQUEST['id']."', '".$fileName."','".$color."','".$color_link."')";
                    if(!empty($fileName)) {
                        $insert = $con->query("INSERT INTO `product_color` (`product_id`, `product_images`, `color`, `link`) VALUES $sqlVal");
                        if($insert) {
                            $color_id = $con->insert_id;
                            if(isset($_FILES['color_gallery']['name'][$id]) && is_array($_FILES['color_gallery']['name'][$id])) {
                                foreach($_FILES['color_gallery']['name'][$id] as $cg_idx => $cg_val) {
                                    if(!empty($cg_val)) {
                                        $cg_fileName = str_replace($a1,$a2,'CG-'.date("d-m-Y")."-".time().$cg_val);
                                        $cg_tempLocation = $_FILES['color_gallery']['tmp_name'][$id][$cg_idx];
                                        $cg_targetFilePath = $location . $cg_fileName;
                                        move_uploaded_file($cg_tempLocation, $cg_targetFilePath);
                                        $con->query("INSERT INTO `product_color_gallery` (`color_id`, `image`) VALUES ('".$color_id."', '".$cg_fileName."')");
                                    }
                                }
                            }
                        }
                    }
            }
            
            }
            if(isset($_FILES['color_gallery_existing']['name'])) {
                foreach($_FILES['color_gallery_existing']['name'] as $color_id => $file_array) {
                    if(is_array($file_array)) {
                        foreach($file_array as $cg_idx => $cg_val) {
                            if(!empty($cg_val)) {
                                $a1 = [".jpg", ".png", ".jpeg"];
                                $a2 = [".webp",".webp",".webp"];
                                $cg_fileName = str_replace($a1,$a2,'CG-E-'.date("d-m-Y")."-".time().$cg_val);
                                $cg_tempLocation = $_FILES['color_gallery_existing']['tmp_name'][$color_id][$cg_idx];
                                $cg_targetFilePath = $location . $cg_fileName;
                                move_uploaded_file($cg_tempLocation, $cg_targetFilePath);
                                $con->query("INSERT INTO `product_color_gallery` (`color_id`, `image`) VALUES ('".$color_id."', '".$cg_fileName."')");
                            }
                        }
                    }
                }
            }
            if(isset($_FILES['dsc']['name'])){
                foreach($_FILES['dsc']['name'] as $id=>$val){
                    
                    $a1 = [".jpg", ".png", ".jpeg"];
                    $a2   = [".webp",".webp",".webp"];
                    $fileName        = str_replace($a1,$a2,'Dsc-'.date("d-m-Y")."-".time().$_FILES['dsc']['name'][$id]);
                    $tempLocation    = $_FILES['dsc']['tmp_name'][$id];
                    $targetFilePath  = $location . $fileName;
                    $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                    // move_uploaded_file($tempLocation, $targetFilePath);
                    $imageSize = $_FILES["dsc"]["size"][$id];
                    if($imageSize<500000){
                        move_uploaded_file($tempLocation, $targetFilePath);
                    }else{
                        $imageTemp = $_FILES["dsc"]["tmp_name"][$id]; 
                        $imageUploadPath = $location . $fileName;
                        $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
                    }
                    $sqlVal = "('".$_REQUEST['id']."', '".$fileName."')";
                    if(!empty($fileName)) {
                        $insert = $con->query("INSERT INTO `product_dsc` (`product_id`, `product_images`) VALUES $sqlVal");
                    }
                }
            }
            if($query_insert){
                $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Product Updated');
            }else{
                $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
            }
        } 
    }if($_REQUEST['page']=='Banner-Item-Add'){
        if(!empty($_FILES['img']['name'])){
            $location = '../uploads/banner/';
            $time_profile = 'banner-'.date("d-m-Y")."-".time() ;
            $profile = basename($_FILES["img"]["name"]);
            $file_profile = $time_profile."-".$profile;
            $targetFile_profile = $location . $file_profile;
            $imageSize = $_FILES["img"]["size"];
            if($imageSize<500000){
                move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile_profile);
            }else{
                $imageTemp = $_FILES["img"]["tmp_name"]; 
                $imageUploadPath = $location . $file_profile;
                $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
            }
        }else{
            $file_profile='';
        }
        $sql_insert = "insert into banner set `image` = '".$file_profile."', title = '".str_replace("'", "\'", $_REQUEST['title'])."', subtitle='',btn='',url='',position=''"; 
        $query_insert = mysqli_query($con, $sql_insert);
        if($query_insert){
            $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'New Banner Added');
        }else{
            $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
        } 
    }
    if($_REQUEST['page']=='Banner-Item-Edit'){
        if(!empty($_FILES['img1']['name'])){
            $location = '../uploads/banner/';
            $time_profile = 'banner-'.date("d-m-Y")."-".time() ;
            $profile = basename($_FILES["img1"]["name"]);
            $file_profile = $time_profile."-".$profile;
            $targetFile_profile = $location . $file_profile;
            $imageSize = $_FILES["img1"]["size"];
            if($imageSize<500000){
                move_uploaded_file($_FILES["img1"]["tmp_name"], $targetFile_profile);
            }else{
                $imageTemp = $_FILES["img1"]["tmp_name"]; 
                $imageUploadPath = $location . $file_profile;
                $compressedImage = compressImage($imageTemp, $imageUploadPath, 75);
            }
            $sql_insert1 = mysqli_query($con, "UPDATE banner set `image` = '".$file_profile."' WHERE id='".$_REQUEST['id']."'");
        }
        $sql_insert = "UPDATE  banner set title = '".str_replace("'", "\'", $_REQUEST['title'])."' WHERE id='".$_REQUEST['id']."'"; 
        $query_insert = mysqli_query($con, $sql_insert);
        if($query_insert){
            $jsonArr=array('statusCode'=>'200','status'=>'success','message'=>'Banner Updated');
        }else{
            $jsonArr=array('statusCode'=>'201','status'=>'error','message'=>'Somthing Errorrr'); 
        } 
    }
    echo json_encode($jsonArr);
    mysqli_close($con);
?>











    