<?php
$page = 'general-setting';
$page1 = '';
include('inc/header.php');
$setting_data = mysqli_fetch_array($con->query("select * from setting"));
?>
<!-- sidebar end -->
<!-- navbar-wrapper start -->
<?php include('inc/sidebar.php') ?>
<!-- navbar-wrapper end -->

<div class="body-wrapper">
    <div class="bodywrapper__inner">
        <div class="row align-items-center mb-30 justify-content-between">
            <div class="col-lg-6 col-sm-6">
                <h6 class="page-title">General Setting</h6>
            </div>
            <div class="col-lg-6 col-sm-6 text-sm-right mt-sm-0 mt-3 ">
            </div>
        </div>
        <form method="post" id="Dashboard-Setting">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header font-weight-bold bg--primary">General Setting</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label class="  font-weight-bold">UPI ID</label>
                                        <input class="form-control form-control-lg" type="text" name="upi" value="<?php echo $setting_data['upi']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group d-flex">
                                        <label class="  font-weight-bold" style="flex: 1;">PhonePay</label>
                                        <?php if ($setting_data['pay1'] == 1) { ?>
                                            <button type="button" data-id="1" data-page="pay1" data-status="0" type="button" class="activeBtn1 icon-btn btn--success"> Enable </button>
                                        <?php } else { ?>
                                            <button type="button" data-id="1" data-page="pay1" data-status="1" type="button" class="activeBtn1 icon-btn btn--danger">Disable</button>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group d-flex">
                                        <label class="  font-weight-bold" style="flex: 1;">GooglePay</label>
                                        <?php if ($setting_data['pay2'] == 1) { ?>
                                            <button type="button" data-id="1" data-page="pay2" data-status="0" type="button" class="activeBtn1 icon-btn btn--success"> Enable </button>
                                        <?php } else { ?>
                                            <button type="button" data-id="1" data-page="pay2" data-status="1" type="button" class="activeBtn1 icon-btn btn--danger">Disable</button>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group d-flex">
                                        <label class="  font-weight-bold" style="flex: 1;">Paytm</label>
                                        <?php if ($setting_data['pay3'] == 1) { ?>
                                            <button type="button" data-id="1" data-page="pay3" data-status="0" type="button" class="activeBtn1 icon-btn btn--success"> Enable </button>
                                        <?php } else { ?>
                                            <button type="button" data-id="1" data-page="pay3" data-status="1" type="button" class="activeBtn1 icon-btn btn--danger">Disable</button>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group d-flex">
                                        <label class="  font-weight-bold" style="flex: 1;">BHIM UPI</label>
                                        <?php if ($setting_data['pay4'] == 1) { ?>
                                            <button type="button" data-id="1" data-page="pay4" data-status="0" type="button" class="activeBtn1 icon-btn btn--success"> Enable </button>
                                        <?php } else { ?>
                                            <button type="button" data-id="1" data-page="pay4" data-status="1" type="button" class="activeBtn1 icon-btn btn--danger">Disable</button>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group d-flex">
                                        <label class="  font-weight-bold" style="flex: 1;">Whatspp pay</label>
                                        <?php if ($setting_data['pay5'] == 1) { ?>
                                            <button type="button" data-id="1" data-page="pay5" data-status="0" type="button" class="activeBtn1 icon-btn btn--success"> Enable </button>
                                        <?php } else { ?>
                                            <button type="button" data-id="1" data-page="pay5" data-status="1" type="button" class="activeBtn1 icon-btn btn--danger">Disable</button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Google Analytics / facebook pixel Code</label>
                                        <textarea name="code" class="form-control" placeholder="Google Analytics Code" id="" cols="20" rows="8"><?php if (isset($setting_data)) {
                                                                                                                                                    echo $setting_data['code'];
                                                                                                                                                } ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn--primary btn-block btn-lg mt-30" name="btn-Setting" id="btn-Setting" type="submit">Update </button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </form>
</div>
<!-- bodywrapper__inner end -->
</div>
<!-- body-wrapper end -->
<!-- jQuery library -->

<?php include('inc/footer.php') ?>
