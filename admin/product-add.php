<?php
function get_admin_img_url($img)
{
    if (empty($img)) return 'assets/img/squre.png';
    $parts = explode(',', $img);
    $first = trim($parts[0]);
    if (strpos($first, 'http') === 0) return $first;
    return PRODUCT_PATH . $first;
}

$page = 'product-add';
$page1 = 'product';
include('inc/header.php');
if (isset($_GET['edit'])) {
    $pro = mysqli_fetch_array($con->query("select * from product WHERE id='" . $_GET['edit'] . "'"));
}
?>

<!-- sidebar end -->
<!-- navbar-wrapper start -->
<?php include('inc/sidebar.php') ?>
<!-- navbar-wrapper end -->
<link rel="stylesheet" href="assets/admin/css/product-add.css">
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
            <input type="hidden" name="page" value="<?php if (!isset($_GET['edit'])) {
                                                        echo 'Product-Item-Add';
                                                    } else {
                                                        echo 'Product-Item-Edit';
                                                    } ?>" />
            <input type="hidden" name="id" value="<?php if (!isset($_GET['edit'])) {
                                                    } else {
                                                        echo $_GET['edit'];
                                                    } ?>" />
            <div class="row mb-5">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header font-weight-bold bg--primary">Product Information</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Product Name <strong class="text-danger">*</strong></label>
                                        <input type="text" class="form-control" placeholder="Product Name" name="name" id="name" value="<?php if (isset($pro)) {
                                                                                                                                            echo $pro['name'];
                                                                                                                                        } ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Slug <strong class="text-danger">*</strong></label>
                                        <input type="text" class="form-control" placeholder="slug" name="slug" id="slug" value="<?php if (isset($pro)) {
                                                                                                                                    echo $pro['slug'];
                                                                                                                                } ?>" required="" />
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Category <strong class="text-danger">*</strong></label>
                                                <select class="form-control" name="category_id" required style="height: 45px; padding: 10px;">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    $cats = mysqli_query($con, "SELECT * FROM category WHERE status=1");
                                                    while ($cat = mysqli_fetch_assoc($cats)) {
                                                        $sel = (isset($pro) && $pro['category_id'] == $cat['id']) ? 'selected' : '';
                                                        echo "<option value='" . $cat['id'] . "' $sel>" . $cat['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Brand <strong class="text-danger">*</strong></label>
                                                <select class="form-control" name="brand_id" required style="height: 45px; padding: 10px;">
                                                    <option value="">Select Brand</option>
                                                    <?php
                                                    $brands = mysqli_query($con, "SELECT * FROM brand WHERE status=1");
                                                    while ($brand = mysqli_fetch_assoc($brands)) {
                                                        $sel = (isset($pro) && $pro['brand_id'] == $brand['id']) ? 'selected' : '';
                                                        echo "<option value='" . $brand['id'] . "' $sel>" . $brand['name'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Mrp <strong class="text-danger">*</strong></label>
                                                <input type="text" class="form-control" placeholder="Mrp" name="mrp" id="" value="<?php if (isset($pro)) {
                                                                                                                                        echo $pro['mrp'];
                                                                                                                                    } ?>" required="" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Sale Price <strong class="text-danger">*</strong></label>
                                                <input type="text" class="form-control" placeholder="Sale Price" name="price" id="" value="<?php if (isset($pro)) {
                                                                                                                                                echo $pro['price'];
                                                                                                                                            } ?>" required="" />
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label>Rating (e.g. 4.5)</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Rating" name="rating" value="<?php if (isset($pro)) {
                                                                                                                                        echo $pro['rating'];
                                                                                                                                    } else {
                                                                                                                                        echo '4.5';
                                                                                                                                    } ?>" required />
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label>Total Reviews Count</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Reviews Count" name="reviews" value="<?php if (isset($pro)) {
                                                                                                                                                echo $pro['reviews'];
                                                                                                                                            } else {
                                                                                                                                                echo '5000';
                                                                                                                                            } ?>" required />
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-6"></div>


                                        <div class="form-group col-lg-12">
                                            <hr /><label>Seller Details</label>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Seller Name</label>
                                            <input type="text" class="form-control" name="seller_name" value="<?php if (isset($pro)) {
                                                                                                                    echo $pro['seller_name'];
                                                                                                                } else {
                                                                                                                    echo 'NGIVR RETAILS';
                                                                                                                } ?>" />
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Seller Rating (e.g. 4.7)</label>
                                            <input type="text" class="form-control" name="seller_rating" value="<?php if (isset($pro)) {
                                                                                                                    echo $pro['seller_rating'];
                                                                                                                } else {
                                                                                                                    echo '4.7';
                                                                                                                } ?>" />
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label>Years with Flipkart</label>
                                            <input type="text" class="form-control" name="seller_years" value="<?php if (isset($pro)) {
                                                                                                                    echo $pro['seller_years'];
                                                                                                                } else {
                                                                                                                    echo '6';
                                                                                                                } ?>" />
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <hr /><label>Rating Breakdown</label>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label>5 Stars Count</label>
                                            <input type="text" class="form-control" name="star_5" value="<?php if (isset($pro)) {
                                                                                                                echo $pro['star_5'];
                                                                                                            } else {
                                                                                                                echo '0';
                                                                                                            } ?>" />
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label>4 Stars Count</label>
                                            <input type="text" class="form-control" name="star_4" value="<?php if (isset($pro)) {
                                                                                                                echo $pro['star_4'];
                                                                                                            } else {
                                                                                                                echo '0';
                                                                                                            } ?>" />
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label>3 Stars Count</label>
                                            <input type="text" class="form-control" name="star_3" value="<?php if (isset($pro)) {
                                                                                                                echo $pro['star_3'];
                                                                                                            } else {
                                                                                                                echo '0';
                                                                                                            } ?>" />
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label>2 Stars Count</label>
                                            <input type="text" class="form-control" name="star_2" value="<?php if (isset($pro)) {
                                                                                                                echo $pro['star_2'];
                                                                                                            } else {
                                                                                                                echo '0';
                                                                                                            } ?>" />
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label>1 Star Count</label>
                                            <input type="text" class="form-control" name="star_1" value="<?php if (isset($pro)) {
                                                                                                                echo $pro['star_1'];
                                                                                                            } else {
                                                                                                                echo '0';
                                                                                                            } ?>" />
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
                                                if (isset($_GET['edit'])) {
                                                    $der = 0;
                                                    $g_qry = mysqli_query($con, "SELECT * FROM product_color WHERE product_id='" . $_GET['edit'] . "' ORDER BY id DESC");
                                                    while ($gallery = mysqli_fetch_array($g_qry)) {
                                                        $der++;
                                                ?>
                                                        <div class="col-lg-3 __gallery_image1 hidee1<?php echo $der ?>" id="hidee1<?php echo $der ?>">
                                                            <div class="form-group">
                                                                <button type="button" onclick="dell_gallery_cat1('<?php echo $gallery['id']; ?>','<?php echo 'hidee1' . $der ?>')" class="btn btn-sm btn--danger"><i class="fas fa-times mr-0"></i></button>
                                                                <div class="image-upload">
                                                                    <div class="thumb">
                                                                        <div class="avatar-preview">
                                                                            <div class="profilePicPreview" style="background-image: url('<?php echo get_admin_img_url($gallery['product_images'] ?? ''); ?>');height:170px;"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="text" class="form-control mb-2" placeholder="Color" name="color" id="color" value="<?php echo $gallery['color']; ?>" disabled />

                                                                <div class="mt-2" style="border:1px solid #ddd; padding:5px; max-height:100px; overflow-y:auto; display:flex; gap:5px; flex-wrap:wrap;">
                                                                    <?php
                                                                    $cg_qry = mysqli_query($con, "SELECT * FROM product_color_gallery WHERE color_id='" . $gallery['id'] . "'");
                                                                    while ($cg = mysqli_fetch_array($cg_qry)) {
                                                                    ?>
                                                                        <div id="cg_<?php echo $cg['id']; ?>" style="position:relative; display:inline-block;">
                                                                            <img src="<?php echo get_admin_img_url($cg['image']); ?>" style="height:40px; width:40px; object-fit:cover; border:1px solid #ccc;" />
                                                                            <span onclick="del_color_gallery(<?php echo $cg['id']; ?>)" style="position:absolute; top:-5px; right:-5px; background:red; color:white; border-radius:50%; width:15px; height:15px; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:10px;">x</span>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>

                                                                <div class="mt-2 text-left">
                                                                    <input type="file" name="color_gallery_existing[<?php echo $gallery['id']; ?>][]" id="cgExisting<?php echo $gallery['id']; ?>" class="colorGalleryUpload" multiple accept=".png, .jpg, .jpeg, .webp" style="display:none;" />
                                                                    <label for="cgExisting<?php echo $gallery['id']; ?>" class="bg--primary text-white" style="margin-top:10px; width:100%; text-align:center; padding:5px; color:#fff !important; border-radius:5px; cursor:pointer;"><i class="fas fa-image"></i> Choose Gallery Images</label>
                                                                    <div class="gallery-preview-container mt-2" style="display:flex; gap:5px; flex-wrap:wrap;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
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
                                            if (isset($_GET['edit'])) {
                                                $der = 0;
                                                $g_qry = mysqli_query($con, "SELECT * FROM product_dsc WHERE product_id='" . $_GET['edit'] . "' ORDER BY id ASC");
                                                while ($dsc = mysqli_fetch_array($g_qry)) {
                                                    $der++;
                                            ?>
                                                    <div class="col-lg-3 __dsc_image hidee<?php echo $der ?>" id="hidee<?php echo $der ?>">
                                                        <div class="form-group">
                                                            <button type="button" onclick="dell_dsc('<?php echo $dsc['id']; ?>','<?php echo 'hidee' . $der ?>')" class="btn btn-sm btn--danger"><i class="fas fa-times mr-0"></i></button>
                                                            <div class="image-upload">
                                                                <div class="thumb">
                                                                    <div class="avatar-preview">
                                                                        <div class="profilePicPreview3" style="background-image: url('<?php echo get_admin_img_url($dsc['product_images'] ?? ''); ?>');height:170px;    background-repeat: round;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php }
                                            } ?>
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
                                                        <div class="profilePicPreview" style="background-image: url('<?php echo get_admin_img_url($pro['image'] ?? ''); ?>');"></div>
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
                                        if (isset($_GET['edit'])) {
                                            $der = 0;
                                            $g_qry = mysqli_query($con, "SELECT * FROM product_images WHERE product_id='" . $_GET['edit'] . "' ORDER BY id DESC");
                                            while ($gallery = mysqli_fetch_array($g_qry)) {
                                                $der++;
                                        ?>
                                                <div class="col-lg-3 __gallery_image hidee<?php echo $der ?>" id="hidee<?php echo $der ?>">
                                                    <div class="form-group">
                                                        <button type="button" onclick="dell_gallery_cat('<?php echo $gallery['id']; ?>','<?php echo 'hidee' . $der ?>')" class="btn btn-sm btn--danger"><i class="fas fa-times mr-0"></i></button>
                                                        <div class="image-upload">
                                                            <div class="thumb">
                                                                <div class="avatar-preview">
                                                                    <div class="profilePicPreview" style="background-image: url('<?php echo get_admin_img_url($gallery['product_images'] ?? ''); ?>');height:170px;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt-5">
                    <div class="form-group">

                        <div class="form-group col-lg-12">
                            <hr /><label>Reviews</label>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <a class="btn btn-outline--success add-review-btn mb-2"><i class="la la-plus"></i> Add Review</a>
                        </div>
                        <div class="row" id="__review_container">
                            <?php
                            if (isset($_GET['edit'])) {
                                $r_qry = mysqli_query($con, "SELECT * FROM product_reviews WHERE product_id='" . $_GET['edit'] . "'");
                                while ($rev = mysqli_fetch_array($r_qry)) {
                            ?>
                                    <div class="col-lg-6 __review_item" id="rev_<?php echo $rev['id']; ?>">
                                        <div class="card border mb-3">
                                            <div class="card-body">
                                                <button type="button" onclick="dell_review('<?php echo $rev['id']; ?>','rev_<?php echo $rev['id']; ?>')" class="btn btn-sm btn--danger float-right mb-2"><i class="fas fa-times mr-0"></i></button>
                                                <input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($rev['name']); ?>" disabled />
                                                <input type="text" class="form-control mb-2" value="<?php echo htmlspecialchars($rev['title']); ?>" disabled />
                                                <div class="profilePicPreview" style="background-image: url('<?php echo get_admin_img_url($rev['image'] ?? ''); ?>');height:100px; width:100px; display:inline-block;"></div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                        </div>

                        <button type="submit" name="btn-popup-Password" id="btn-popup-Password" value="<?php if (isset($_GET['edit'])) {
                                                                                                            echo 'Update';
                                                                                                        } else {
                                                                                                            echo 'Submit';
                                                                                                        } ?>" class="btn btn--primary w-100"><?php if (isset($_GET['edit'])) {
                                                                                                                                                                                                                        echo 'Update';
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                        echo 'Submit';
                                                                                                                                                                                                                    } ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- bodywrapper__inner end -->
</div>
<script>
    jQuery('#name').keyup(function() {
        jQuery('#result').html('');
        var name = jQuery('#name').val();
        jQuery.ajax({
            url: 'module/get-product-slug.php',
            type: 'post',
            data: 'name=' + name,
            success: function(result) {
                // jQuery('#slug').val(result);
                var trimStr = $.trim(result);
                jQuery('#slug').val(trimStr);
            }
        });
    });
</script>
<script>
    $(".add-review-btn").on('click', function(e) {
        let index = $(document).find(".__review_item_new").length;
        let html = `
                        <div class="col-lg-6 __review_item_new">
                            <div class="card border mb-3">
                                <div class="card-body">
                                    <button type="button" class="btn btn-sm btn--danger remove-review-btn float-right mb-2"><i class="fas fa-times mr-0"></i></button>
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <input type="text" class="form-control" name="rev_name[]" placeholder="Reviewer Name" required/>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <input type="text" class="form-control" name="rev_location[]" placeholder="Location (e.g. Roorkee)"/>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <input type="text" class="form-control" name="rev_time[]" placeholder="Time (e.g. 1 month ago)"/>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <select class="form-control" name="rev_rating[]">
                                                <option value="5">5 Star</option>
                                                <option value="4">4 Star</option>
                                                <option value="3">3 Star</option>
                                                <option value="2">2 Star</option>
                                                <option value="1">1 Star</option>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <input type="text" class="form-control" name="rev_title[]" placeholder="Review Title" required/>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <textarea class="form-control" name="rev_text[]" placeholder="Review Content" rows="3" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label>Review Image (Optional)</label>
                                            <input type="file" class="form-control" name="rev_image[]" accept=".png, .jpg, .jpeg, .webp">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
        $("#__review_container").append(html)
    });

    $(document).on('click', '.remove-review-btn', function() {
        $(this).closest('.__review_item_new').remove();
    });

    function dell_review(pid, type) {
        $.ajax({
            url: 'module/dell_review.php',
            type: 'post',
            data: 'id=' + pid,
            success: function(data) {
                $('#' + type).hide();
            }
        });
    }

    function del_color_gallery(id) {
        if (confirm("Are you sure you want to delete this gallery image?")) {
            $.ajax({
                type: "POST",
                url: "module/del_color_gallery.php",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#cg_' + id).hide();
                }
            });
        }
    }

    function dell_gallery_cat(pid, type) {
        jQuery.ajax({
            url: 'module/dell_gallery_cat.php',
            type: 'post',
            data: 'pid=' + pid + '&type=' + type,
            success: function(result) {
                var trimStr = $.trim(result);
                document.getElementById(trimStr).style.display = "none";
            }
        });
    }
</script>
<script>
    function dell_dsc(pid, type) {
        jQuery.ajax({
            url: 'module/dell_dsc.php',
            type: 'post',
            data: 'pid=' + pid + '&type=' + type,
            success: function(result) {
                var trimStr = $.trim(result);
                document.getElementById(trimStr).style.display = "none";
            }
        });
    }
</script>
<script>
    function dell_gallery_cat1(pid, type) {
        jQuery.ajax({
            url: 'module/dell_gallery_cat1.php',
            type: 'post',
            data: 'pid=' + pid + '&type=' + type,
            success: function(result) {
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

        $(document).on('click', '.removeBtn', function() {
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
        $("body").on('change', '.profilePicUpload', function() {
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
                                            <input type="text" class="form-control" placeholder="Color Name" name="color[]" />
                                            <input type="file" class="profilePicUpload" name="gallery1[]" id="1profilePicUploadItem${index}" accept=".png, .jpg, .jpeg, .webp">
                                            <label for="1profilePicUploadItem${index}" class="bg--success text-white" style="margin-top:10px; color:#fff !important;">Main Image</label>

                                            <div class="mt-2 text-left">
                                                <input type="file" class="colorGalleryUpload" name="color_gallery[${index}][]" id="colorGalleryItem${index}" multiple accept=".png, .jpg, .jpeg, .webp" style="display:none;">
                                                <label for="colorGalleryItem${index}" class="bg--primary text-white" style="margin-top:10px; width:100%; text-align:center; padding:5px; color:#fff !important; border-radius:5px; cursor:pointer;"><i class="fas fa-image"></i> Choose Gallery Images</label>
                                                <div class="gallery-preview-container mt-2" style="display:flex; gap:5px; flex-wrap:wrap;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
            $("#__gallery_image1").append(html)

        });

        $(document).on('click', '.removeBtn1', function() {
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
        $("body").on('change', '.profilePicUpload1', function() {
            proPicURL(this);
        });

        $("body").on('change', '.colorGalleryUpload', function() {
            var container = $(this).siblings('.gallery-preview-container');
            container.empty();
            if (this.files) {
                Array.from(this.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var img = $('<img/>').attr('src', e.target.result).css({
                            'height': '40px',
                            'width': '40px',
                            'object-fit': 'cover',
                            'border': '1px solid #ccc',
                            'border-radius': '4px'
                        });
                        container.append(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });

    })(jQuery);
</script>
<script>
    "use strict";
    (function($) {

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
        $("body").on('change', '.profilePicUpload', function() {
            proPicURL(this);
        });

        $("body").on('click', '.minus-specification1', function(e) {
            $(this).closest('.specification1').remove()
            $(document).find(".specification1").length <= 0 ? $("#specifications1-title").show() : "";

        })



    })(jQuery);
</script>

<script>
    function dell_att(pid, type) {
        jQuery.ajax({
            url: 'module/dell_att.php',
            type: 'post',
            data: 'pid=' + pid + '&type=' + type,
            success: function(result) {
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

        $(document).on('click', '.removeBtn', function() {
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
        $("body").on('change', '.profilePicUpload3', function() {
            proPicURL(this);
        });

    })(jQuery);
</script>
<!-- body-wrapper end -->
<?php include('inc/footer.php') ?>
