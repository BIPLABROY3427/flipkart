
      <?php 
      $page='all-product';
      $page1='product';
      include('inc/header.php');
      ?>
        <!-- sidebar end -->
        <!-- navbar-wrapper start -->
        <?php include('inc/sidebar.php') ?>
        <!-- navbar-wrapper end -->
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="row align-items-center mb-30 justify-content-between">
                    <div class="col-lg-6 col-6">
                        <h6 class="page-title">Manage Product</h6>
                    </div>
                    <div class="col-lg-6 col-sm-6 text-sm-right mt-sm-0 mt-3 ">
                        <button  onclick="location.reload();location.href='product-add.php'"type="button" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-plus"></i>Add New</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive--md table-responsive">
                                    <table id="example" class="table table--light style--two">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Mrp</th>
                                                <th>Sale Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            <?php	
                                                $sql= mysqli_query($con, "SELECT * FROM product ORDER BY id DESC");
                                                $i=0;
                                                while($data= mysqli_fetch_array($sql)){ $i++;         
                                            ?>
                                            <tr>
                                                <td data-label="SL"><?php echo $i; ?></td>
                                                
                                                <td data-label="Image"><img src="<?php echo PRODUCT_PATH.$data['image']; ?>"style="width:40px;height:40px;"></td>
                                                <td data-label="Product Name"><?php echo $data['name']; ?></td>
                                                <td data-label="Mrp"><?php echo '₹ '.number_format($data['mrp']); ?></td>
                                                <td data-label="Sale Price"><?php echo '₹ '.number_format($data['price']); ?></td>
                                                <td data-label="Action">
                                                    <?php if($data['status']==1){ ?>
                                                    <button type="button" data-id="<?php echo $data['id']; ?>" data-page="product"data-status="0" type="button" class="activeBtn icon-btn btn--success"> ACTIVE </button>
                                                    <?php }else{?>
                                                    <button type="button" data-id="<?php echo $data['id']; ?>" data-page="product"data-status="1" type="button" class="activeBtn icon-btn btn--danger">DEACTIVE</button>
                                                    <?php } ?>
                                                    <button class="icon-btn " onclick="location.reload();location.href='product-add.php?edit=<?php echo $data['id'];?>'"><i class="la la-pencil-alt"></i></button>
                                                    <button type="button" data-id="<?php echo $data['id']; ?>" data-page="product" class="icon-btn btn--danger removeBtn" fdprocessedid="vnry2"><i class="la la-trash"></i></button>
                                                </td>
                                               
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- bodywrapper__inner end -->
        </div>
        <!-- body-wrapper end --> 
    <?php include('inc/footer.php') ?>