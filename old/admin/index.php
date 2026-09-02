<?php include('inc/conn.php');
if(!isset($_SESSION['ID'])==true){   
    $get_setting= mysqli_fetch_array($con->query("select * from setting"));

?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- site favicon -->
    <!-- bootstrap 4  -->
    <link rel="stylesheet" href="assets/admin/css/vendor/grid.min.css" />
    <!-- bootstrap toggle css -->
    <link rel="stylesheet" href="assets/admin/css/vendor/bootstrap-toggle.min.css" />
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="assets/global/css/all.min.css" />
    <!-- dashdoard main css -->
    <link rel="stylesheet" href="assets/admin/css/app.css" />
    <script src="assets/global/js/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="page main-signin-wrapper">
        <div class="signpages text-center row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row-sm row">
                        <div class="login_form  col-xl-12 col-lg-12 col-sm-12 col-12">
                            <div class="container-fluid">
                                <div class="row-sm row">
                                    <div class="mt-2 mb-2 card-body">
                                        <form method="post" class="cmn-form mt-30" id="Dashboard-Login">
                                            <h3 class="text-center mb-2">Admin Login</h3>
                                            <p class="mb-4 text-muted tx-13 ms-0 text-center"> Signin to Your Account</p>
                                            <div class="text-start form-group">
                                                <label class="form-label" for="formEmail">Username</label>
                                                <input type="text" name="username" class="form-control form-control" id="username" required>
                                            <div class="text-start form-group">
                                                <label class="form-label" for="formpassword">Password</label>
                                                <input type="password" name="password" class="form-control form-control" id="pass"required>
                                            </div>
                                            <button class="btn ripple btn-main-primary btn-block mt-2 btn btn-primary" name="btn-save" id="btn-login" type="submit">Sign In <i class="las la-sign-in-alt"></i></button>
                                        </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <!-- jQuery library -->
    <script src="assets/admin/js/vendor/grid.min.js"></script>
    <script src="assets/admin/js/vendor/jquery.nice-select.min.js"></script>
    <link rel="stylesheet" href="assets/global/css/iziToast.min.css" />
    <script src="assets/global/js/iziToast.min.js"></script>
    
    <script>
        "use strict";
        function notify(status, message) {
            iziToast[status]({
                message: message,
                position: "topRight",
            });
        }
    </script>
    <script>
        
    </script>
    <!-- seldct 2 js -->
    <script src="assets/admin/js/vendor/select2.min.js"></script>
    <script src="assets/admin/js/nicEdit.js"></script>
    <script src="assets/admin/js/app.js"></script>
    <script src="assets/DataTables/DataTables-1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/admin/js/parsley.js"></script>
   
</body>
</html>
<?php
}else{
    echo "<script type='text/javascript'>window.location=\"dashboard.php\";</script>";
}
?>