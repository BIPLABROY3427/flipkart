<?php 
    $page='dashboard'; 
      $page1='';
    include('inc/header.php'); 
?>
            <!-- sidebar end -->
            <!-- navbar-wrapper start -->
            <?php include('inc/sidebar.php') ?>
            <!-- navbar-wrapper end -->

            <div class="body-wrapper">
                <div class="bodywrapper__inner">
                    <div class="row align-items-center mb-30 justify-content-between">
                        <div class="col-lg-6 col-sm-6">
                            <h6 class="page-title">Dashboard</h6>
                        </div>
                        <div class="col-lg-6 col-sm-6 text-sm-right mt-sm-0 mt-3 right-part">
                            <a href="javascript:void(0)" class="btn btn--danger" >Last Login <i class="fa fa-fw fa-clock"></i> <span class="text-white"><?php echo $get_admin['last_login'] ?></span></a>
                        </div>
                    </div>

                    <div class="row mb-none-30">
                        <div class="col-xl-3 col-lg-4 col-sm-6 mb-30">
                            <div class="dashboard-w1 bg--primary b-radius--10 box-shadow">
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="details">
                                    <div class="numbers">
                                        <span class="amount"><?php echo $sql_order = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `product`")); ?></span>
                                    </div>
                                    <div class="desciption">
                                        <span class="text--small">Total Products</span>
                                    </div>
                                    <a href="product.php" class="btn btn-sm text--small bg--white text--black box--shadow3 mt-3">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- row end-->

                    
                </div>
                <!-- bodywrapper__inner end -->
            </div>
            <!-- body-wrapper end -->
           
            <?php include('inc/footer.php') ?>