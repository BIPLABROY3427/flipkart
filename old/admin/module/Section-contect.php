
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
            $sql_insert = "insert into product set `image` = '".$file_profile."', name = '".str_replace("'", "\'", $_REQUEST['name'])."',slug = '".$_REQUEST['slug']."',mrp = '".$_REQUEST['mrp']."',price = '".$_REQUEST['price']."', status = '1'"; 
            $query_insert = mysqli_query($con, $sql_insert);
            $store_id=mysqli_insert_id($con);
                
            if($query_insert){
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
                        $sqlVal = "('".$store_id."', '".$fileName."','".$color."')";
                        if(!empty($fileName)) {
                            $insert = $con->query("INSERT INTO `product_color` (`product_id`, `product_images`, `color`) VALUES $sqlVal");
                        }
                    }
                }
                if(isset($_POST['storage'])){
                    foreach($_POST['storage'] as $key=>$val){
                        if(isset($_REQUEST['storage'])==true){
                            $storage=$_POST['storage'][$key];
                        }
                        if(isset($_REQUEST['size'])){
                            $size=$_POST['size'][$key];
                        }
                        if(isset($_REQUEST['attr_id'])==true){
                            $attr_id=$_POST['attr_id'][$key];
                        }else{
                            $attr_id=0;
                        }
                        
                        if($attr_id>0){
                            mysqli_query($con,"update product_attributes set storage='$storage',size='$size' where id='$attr_id'");
                        }else{
                            mysqli_query($con,"insert into product_attributes(product_id,storage,size) values('".$store_id."','$storage','$size')");
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
            $sql_insert = "UPDATE  product set name = '".str_replace("'", "\'", $_REQUEST['name'])."',slug = '".$_REQUEST['slug']."',mrp = '".$_REQUEST['mrp']."',price = '".$_REQUEST['price']."' WHERE id='".$_REQUEST['id']."'"; 
            $query_insert = mysqli_query($con, $sql_insert);
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
                    $sqlVal = "('".$_REQUEST['id']."', '".$fileName."','".$color."')";
                    if(!empty($fileName)) {
                        $insert = $con->query("INSERT INTO `product_color` (`product_id`, `product_images`, `color`) VALUES $sqlVal");
                    }
                }
            }
            if(isset($_REQUEST['storage'])==true){
                foreach($_REQUEST['storage'] as $key=>$val){
                    if(isset($_REQUEST['storage'])){
                        $storage=$_REQUEST['storage'][$key];
                    }
                    if(isset($_REQUEST['size'])==true){
                        $size=$_REQUEST['size'][$key];
                    }
                    if(isset($_REQUEST['attr_id'])==true){
                        $attr_id=$_REQUEST['attr_id'][$key];
                    }else{
                        $attr_id=0;
                    }
                    
                    if($attr_id>0){
                        mysqli_query($con,"update product_attributes set storage='$storage',size='$size' where id='$attr_id'");
                    }else{
                        mysqli_query($con,"insert into product_attributes(product_id,storage,size) values('".$_REQUEST['id']."','$storage','$size')");
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











    