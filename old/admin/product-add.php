<?php 
    $page='product-add';
      $page1='product';
    include('inc/header.php');
    if(isset($_GET['edit'])){
        $pro= mysqli_fetch_array($con->query("select * from product WHERE id='".$_GET['edit']."'"));
    }
?>

            <!-- sidebar end -->
            <!-- navbar-wrapper start -->
            <?php include('inc/sidebar.php') ?>
            <!-- navbar-wrapper end -->
            <div class="body-wrapper">
                <div class="bodywrapper__inner">
                    <div class="row align-items-center mb-30 justify-content-between">
                        <div class="col-lg-6 col-sm-6">
                            <h6 class="page-title">Manage Product</h6>
                        </div>
                        <div class="col-lg-6 col-sm-6 text-sm-right mt-sm-0 mt-3 right-part">
                            <a onclick="history.back()" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="las la-backward"></i>Back</a>
                        </div>
                    </div> 

                    <form method="post" id="Form-popup-Section-Add">
                        <input type="hidden" name="page" value="<?php if(!isset($_GET['edit'])){ echo 'Product-Item-Add'; }else{ echo 'Product-Item-Edit'; } ?>" />
                        <input type="hidden" name="id" value="<?php if(!isset($_GET['edit'])){ }else{ echo $_GET['edit']; } ?>" />
                        <div class="row mb-5">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header font-weight-bold bg--primary">Product Information</div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Product Name <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" placeholder="Product Name" name="name"id="name" value="<?php if(isset($pro)){echo $pro['name'];} ?>"required="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Slug <strong class="text-danger">*</strong></label>
                                                    <input type="text" class="form-control" placeholder="slug" name="slug" id="slug" value="<?php if(isset($pro)){echo $pro['slug'];} ?>"  required=""/>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Mrp <strong class="text-danger">*</strong></label>
                                                            <input type="text" class="form-control" placeholder="Mrp" name="mrp" id="" value="<?php if(isset($pro)){echo $pro['mrp'];} ?>"  required=""/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Sale Price <strong class="text-danger">*</strong></label>
                                                            <input type="text" class="form-control" placeholder="Sale Price" name="price" id="" value="<?php if(isset($pro)){echo $pro['price'];} ?>"  required=""/>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-md-2">
                                                        <label for="" class="font-weight-bold">Color</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div class="row">
                                                            <div class="col-lg-12 text-right">
                                                                <a class="btn btn-outline--success add-gallery-image1 mb-2"><i class="la la-plus"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="__gallery_image1">
                                                            <?php	
                                                                if(isset($_GET['edit'])){
                                                                $der=0;
                                                                $g_qry= mysqli_query($con,"SELECT * FROM product_color WHERE product_id='".$_GET['edit']."' ORDER BY id DESC");
                                                                while($gallery= mysqli_fetch_array($g_qry))
                                                                { $der++;
                                                            ?>
                                                            <div class="col-lg-3 __gallery_image1 hidee1<?php echo $der ?>" id="hidee1<?php echo $der ?>">
                                                                <div class="form-group">
                                                                    <button type="button" onclick="dell_gallery_cat1('<?php echo $gallery['id']; ?>','<?php echo 'hidee1'.$der ?>')" class="btn btn-sm btn--danger"><i class="fas fa-times mr-0"></i></button>
                                                                    <div class="image-upload">
                                                                        <div class="thumb">
                                                                            <div class="avatar-preview">
                                                                                <div class="profilePicPreview" style="background-image: url('<?php if(!empty($gallery['product_images'])){ echo PRODUCT_PATH.$gallery['product_images']; }else{ echo 'assets/img/squre.png';} ?>');height:170px;"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="text" class="form-control" placeholder="Color" name="color" id="color"value="<?php echo $gallery['color']; ?>" disabled/>
                                                                </div>
                                                            </div>
                                                            <?php }} ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12" id="specification1">
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                <label class="font-weight-bold">Storage (Don't use any Special Character)</label>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <label class="font-weight-bold">Size (Don't use any Special Character)</label>
                                                            </div>
                                                            <?php if(!isset($_GET['edit'])){ ?>
                                                            <div class="col-lg-5">
                                                                <input type="text" class="form-control" name="storage[]" value=""  placeholder="Storage">
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <input type="text" class="form-control" name="size[]" value=""  placeholder="Size" >
                                                            </div>
                                                            
                                                            <?php } ?>
                                                           
                                                            <div class="col-lg-2 text-right">
                                                                <a class="btn btn-outline--success add-specification1 mb-2"><i class="la la-plus"></i></a>
                                                            </div>
                                                        </div>
                                                        <?php	
                                                        if(isset($_GET['edit'])){
                                                            $att=0;
                                                            $sql_attributes= mysqli_query($con, "SELECT * FROM product_attributes WHERE product_id='".$pro['id']."'");
                                                            while($attributes_data= mysqli_fetch_array($sql_attributes)){ $att++;
                                                                       
                                                        ?>
                                                        <div class="row mb-2 specification1" id="hide<?php echo $att ?>">
                                                            <div class="col-lg-5">
                                                                <input type="text" class="form-control" name="storage[]" value="<?php echo $attributes_data['storage']; ?>"  placeholder="Storage">
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <input type="text" class="form-control" name="size[]" value="<?php echo $attributes_data['size']; ?>"  placeholder="Size" >
                                                            </div>
                                                            <div class="col-lg-2 text-right minus-specification1">
                                                                <a class="btn btn-outline--danger"  onclick="dell_att('<?php echo $attributes_data['id']; ?>','<?php echo 'hide'.$att ?>')"><i class="la la-minus"></i></a>
                                                            </div>
                                                            <input type="hidden" name="attr_id[]" value='<?php echo $attributes_data['id']?>'/>
                                                        </div>
                                                        <?php }} ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold">Description (Upload Image Less Than 1MB)</label>
                                                    
                                                        <div class="row">
                                                            <div class="col-lg-12 text-right">
                                                                <a class="btn btn-outline--success add-dsc-image mb-2"><i class="la la-plus"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="row" id="__dsc_image">
                                                            <?php	
                                                                if(isset($_GET['edit'])){
                                                                $der=0;
                                                                $g_qry= mysqli_query($con,"SELECT * FROM product_dsc WHERE product_id='".$_GET['edit']."' ORDER BY id ASC");
                                                                while($dsc= mysqli_fetch_array($g_qry))
                                                                { $der++;
                                                            ?>
                                                            <div class="col-lg-3 __dsc_image hidee<?php echo $der ?>" id="hidee<?php echo $der ?>">
                                                                <div class="form-group">
                                                                    <button type="button" onclick="dell_dsc('<?php echo $dsc['id']; ?>','<?php echo 'hidee'.$der ?>')" class="btn btn-sm btn--danger"><i class="fas fa-times mr-0"></i></button>
                                                                    <div class="image-upload">
                                                                        <div class="thumb">
                                                                            <div class="avatar-preview">
                                                                                <div class="profilePicPreview3" style="background-image: url('<?php if(!empty($dsc['product_images'])){ echo PRODUCT_PATH.$dsc['product_images']; }else{ echo 'assets/img/squre.png';} ?>');height:170px;    background-repeat: round;"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php }} ?>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <div class="card">
                                    <div class="card-header font-weight-bold bg--primary">Product Image</div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="" class="font-weight-bold">Thumbnail <strong class="text-danger">*</strong></label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="d-flex">
                                                    <div class="payment-method-item">
                                                        <div class="payment-method-header d-flex flex-wrap">
                                                            <div class="thumb">
                                                                <div class="avatar-preview">
                                                                    <div class="profilePicPreview" style="background-image: url('<?php if(isset($pro)){ echo PRODUCT_PATH.$pro['image'];} ?>');"></div>
                                                                </div>
                                                                <div class="avatar-edit">
                                                                    <input type="file" name="img" class="profilePicUpload" id="image" accept=".png, .jpg, .jpeg, .webp" />
                                                                    <label for="image" class="bg--primary"><i class="la la-pencil"></i></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="" class="font-weight-bold">Gallery</label>
                                            </div>
                                            <div class="col-md-10">
                                                <div class="row">
                                                    <div class="col-lg-12 text-right">
                                                        <a class="btn btn-outline--success add-gallery-image mb-2"><i class="la la-plus"></i></a>
                                                    </div>
                                                </div>
                                                <div class="row" id="__gallery_image">
                                                    <?php	
                                                        if(isset($_GET['edit'])){
                                                        $der=0;
                                                        $g_qry= mysqli_query($con,"SELECT * FROM product_images WHERE product_id='".$_GET['edit']."' ORDER BY id DESC");
                                                        while($gallery= mysqli_fetch_array($g_qry))
                                                        { $der++;
                                                    ?>
                                                    <div class="col-lg-3 __gallery_image hidee<?php echo $der ?>" id="hidee<?php echo $der ?>">
                                                        <div class="form-group">
                                                            <button type="button" onclick="dell_gallery_cat('<?php echo $gallery['id']; ?>','<?php echo 'hidee'.$der ?>')" class="btn btn-sm btn--danger"><i class="fas fa-times mr-0"></i></button>
                                                            <div class="image-upload">
                                                                <div class="thumb">
                                                                    <div class="avatar-preview">
                                                                        <div class="profilePicPreview" style="background-image: url('<?php if(!empty($gallery['product_images'])){ echo PRODUCT_PATH.$gallery['product_images']; }else{ echo 'assets/img/squre.png';} ?>');height:170px;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php }} ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5">
                                <div class="form-group">
                                <button type="submit" name="btn-popup-Password" id="btn-popup-Password" value="<?php if(isset($_GET['edit'])){ echo 'Update';  }else{ echo 'Submit'; } ?>"class="btn btn--primary w-100"><?php if(isset($_GET['edit'])){ echo 'Update';  }else{ echo 'Submit'; } ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- bodywrapper__inner end -->
            </div>
            <script>
                    jQuery('#name').keyup(function(){
                        jQuery('#result').html('');
                        var name=jQuery('#name').val();
                        jQuery.ajax({
                            url:'module/get-product-slug.php',
                            type:'post',
                            data:'name='+name,
                            success:function(result){
                                // jQuery('#slug').val(result);
                                var trimStr = $.trim(result);
                                jQuery('#slug').val(trimStr);
                            }
                        });
                    });
            </script>
            <script>
                function dell_gallery_cat(pid,type){
                    jQuery.ajax({
                        url:'module/dell_gallery_cat.php',
                        type:'post',
                        data:'pid='+pid+'&type='+type,
                        success:function(result){
                            var trimStr = $.trim(result);
                            document.getElementById(trimStr).style.display = "none";
                        }	
                    });	
                }
            </script>
            <script>
                function dell_dsc(pid,type){
                    jQuery.ajax({
                        url:'module/dell_dsc.php',
                        type:'post',
                        data:'pid='+pid+'&type='+type,
                        success:function(result){
                            var trimStr = $.trim(result);
                            document.getElementById(trimStr).style.display = "none";
                        }	
                    });	
                }
            </script>
            <script>
                function dell_gallery_cat1(pid,type){
                    jQuery.ajax({
                        url:'module/dell_gallery_cat1.php',
                        type:'post',
                        data:'pid='+pid+'&type='+type,
                        success:function(result){
                            var trimStr = $.trim(result);
                            document.getElementById(trimStr).style.display = "none";
                        }	
                    });	
                }
            </script>
            <script>
                "use strict";
                (function($) {
                    $(".add-gallery-image").on('click', function(e) {
                        let index = $(document).find(".__gallery_image").length;
                        index = index + 1;
                        let html = `
                        <div class="col-lg-3 __gallery_image">
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn--danger removeBtn"><i class="fas fa-times mr-0"></i></button>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url(assets/img/squre.png);height:170px;" ></div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="gallery[]" id="profilePicUploadItem${index}" accept=".png, .jpg, .jpeg, .webp">
                                            <label for="profilePicUploadItem${index}" class="bg--success">Select</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                        $("#__gallery_image").append(html)

                    });

                    $(document).on('click','.removeBtn',function (){
                        $(this).closest('.__gallery_image').remove();
                    });

                    function proPicURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var preview = $(input).parents('.thumb').find('.profilePicPreview');
                                $(preview).css('background-image', 'url(' + e.target.result + ')');
                                $(preview).addClass('has-image');
                                $(preview).hide();
                                $(preview).fadeIn(650);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("body").on('change','.profilePicUpload',function() {
                        proPicURL(this);
                    });

                })(jQuery);
            </script>
            <script>
                "use strict";
                (function($) {
                    $(".add-gallery-image1").on('click', function(e) {
                        let index = $(document).find(".__gallery_image1").length;
                        index = index + 1;
                        let html = `
                        <div class="col-lg-3 __gallery_image1">
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn--danger removeBtn1"><i class="fas fa-times mr-0"></i></button>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url(assets/img/squre.png);height:170px;" ></div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="text" class="form-control" placeholder="Color" name="color[]" id="color" />
                                            <input type="file" class="profilePicUpload" name="gallery1[]" id="1profilePicUploadItem${index}" accept=".png, .jpg, .jpeg, .webp">
                                            <label for="1profilePicUploadItem${index}" class="bg--success">Select</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                        $("#__gallery_image1").append(html)

                    });

                    $(document).on('click','.removeBtn1',function (){
                        $(this).closest('.__gallery_image1').remove();
                    });

                    function proPicURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var preview = $(input).parents('.thumb').find('.profilePicPreview1');
                                $(preview).css('background-image', 'url(' + e.target.result + ')');
                                $(preview).addClass('has-image');
                                $(preview).hide();
                                $(preview).fadeIn(650);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("body").on('change','.profilePicUpload1',function() {
                        proPicURL(this);
                    });

                })(jQuery);
            </script>
            <script>
            "use strict";
            (function($) {

                $(".add-specification1").on('click', function(e) {
                    let index = $(document).find(".specification1").length;
                    index = parseInt(index) + parseInt(1);
                    let html = `
                    <div class="row mb-2 specification1">
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="storage[]" placeholder="Storage">
                        </div>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="size[]"  placeholder="Size" >
                        </div>
                        <div class="col-lg-2 text-right minus-specification1">
                            <a class="btn btn-outline--danger "><i class="la la-minus"></i></a>
                        </div>
                    </div>
                    `;
                        $("#specification1").append(html)
                        $("#specifications1-title").hide()
                    })
                

                function proPicURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var preview = $(input).parents('.thumb').find('.profilePicPreview');
                            $(preview).css('background-image', 'url(' + e.target.result + ')');
                            $(preview).addClass('has-image');
                            $(preview).hide();
                            $(preview).fadeIn(650);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("body").on('change','.profilePicUpload',function() {
                    proPicURL(this);
                });

                $("body").on('click','.minus-specification1',function(e){
                    $(this).closest ('.specification1').remove()
                    $(document).find(".specification1").length <=0 ?  $("#specifications1-title").show() : "" ;

                })



            })(jQuery);

        </script>
        
        <script>
                function dell_att(pid,type){
                    jQuery.ajax({
                        url:'module/dell_att.php',
                        type:'post',
                        data:'pid='+pid+'&type='+type,
                        success:function(result){
                            var trimStr = $.trim(result);
                            document.getElementById(trimStr).style.display = "none";
                        }	
                    });	
                }
            </script>
            <script>
                "use strict";
                (function($) {
                    $(".add-dsc-image").on('click', function(e) {
                        let index = $(document).find(".__dsc_image").length;
                        index = index + 1;
                        let html = `
                        <div class="col-lg-3 __dsc_image">
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn--danger removeBtn"><i class="fas fa-times mr-0"></i></button>
                                <div class="image-upload">
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url(assets/img/squre.png);height:170px;" ></div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="dsc[]" id="3profilePicUploadItem${index}" accept=".png, .jpg, .jpeg, .webp">
                                            <label for="3profilePicUploadItem${index}" class="bg--success">Select</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                        $("#__dsc_image").append(html)

                    });

                    $(document).on('click','.removeBtn',function (){
                        $(this).closest('.__dsc_image').remove();
                    });

                    function proPicURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var preview = $(input).parents('.thumb').find('.profilePicPreview3');
                                $(preview).css('background-image', 'url(' + e.target.result + ')');
                                $(preview).addClass('has-image');
                                $(preview).hide();
                                $(preview).fadeIn(650);
                            }
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                    $("body").on('change','.profilePicUpload3',function() {
                        proPicURL(this);
                    });

                })(jQuery);
            </script>
            <!-- body-wrapper end -->
        <?php include('inc/footer.php') ?>