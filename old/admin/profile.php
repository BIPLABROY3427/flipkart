<?php 
    $page='';
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
                        <div class="col-lg-4 col-sm-6">
                            <h6 class="page-title">Profile</h6>
                        </div>
                        <div class="col-lg-8 col-sm-6 text-sm-right mt-sm-0 mt-3 right-part">
                            <a href="#Pass" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="fa fa-key"></i>Password Setting</a>
                        </div>
                    </div>
                    <div class="row mb-none-30">
                        <div class="col-xl-4 col-lg-4 mb-30">
                            <div class="card b-radius--5 overflow-hidden">
                                <div class="card-body p-0">
                                    <div class="d-flex p-3 bg--primary align-items-center">
                                        <div class="avatar avatar--lg">
                                            <img src="<?php echo PROFILE_PATH.$get_admin['image']; ?>" alt="Image">
                                        </div>
                                        <div class="pl-3">
                                            <h4 class="text--white"><?php echo $get_admin['username']; ?></h4>
                                        </div>
                                    </div>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Name                            <span class="font-weight-bold"><?php echo $get_admin['name']; ?></span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Username                            <span class="font-weight-bold"><?php echo $get_admin['username']; ?></span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Email                            <span class="font-weight-bold"><?php echo $get_admin['email']; ?></span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-8 mb-30">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-50 border-bottom pb-2">Profile Information</h5>
                                    <form id="Admin-Profile" >
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <div class="image-upload">
                                                        <div class="thumb">
                                                            <div class="avatar-preview">
                                                                <div class="profilePicPreview" style="background-image: url('<?php echo PROFILE_PATH.$get_admin['image']; ?>')">
                                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                                </div>
                                                            </div>
                                                            <div class="avatar-edit">
                                                                <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">
                                                                <label for="profilePicUpload1" class="bg--success">Upload Image</label>
                                                                <small class="mt-2 text-facebook">Supported files: <b>jpeg, jpg.</b> Image will be resized into 400x400px </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group ">
                                                    <label class="form-control-label font-weight-bold">Name</label>
                                                    <input class="form-control" type="text" name="name" value="<?php echo $get_admin['name']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-control-label  font-weight-bold">Email</label>
                                                    <input class="form-control" type="email" name="email" value="<?php echo $get_admin['email']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn--primary btn-block btn-lg" name="btn-Profile" id="btn-Profile" type="submit">Update </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mt-20"id="Pass">
                                <div class="card-body">
                                    <h5 class="card-title mb-50 border-bottom pb-2">Change Password</h5>
                                    <form method="post" id="Admin-Password">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Password</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="password" name="old-password" placeholder="Old Password" value="" id="old-password" required=""  data-parsley-required-message="Please Enter Your Old Password."  data-parsley-required="" data-parsley-trigger="keyup">
                                                <i class="fa fa-eye-slash togglePassword" id="togglePassword1"></i>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">New Password</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="password" name="new-password" placeholder="Password" value="" id="new-password" required="" data-parsley-minlength="8" data-parsley-errors-container=".errorspannewpassinput" data-parsley-required-message="Please Enter Your Password." data-parsley-uppercase="1" data-parsley-lowercase="1" data-parsley-number="1" data-parsley-special="1" data-parsley-required="" data-parsley-trigger="keyup">
                                                <i class="fa fa-eye-slash togglePassword" id="togglePassword2"></i>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label">Confirm Password</label>
                                            <div class="col-lg-9">
                                                <input class="form-control" type="password" name="cnew-password" placeholder="Confirm Password" value="" id="cnew-password" required="" data-parsley-minlength="8" data-parsley-errors-container=".errorspanconfirmnewpassinput" data-parsley-required-message="Please Confirm Your Password." data-parsley-equalto="#new-password" data-parsley-required="" data-parsley-trigger="keyup">
                                                <i class="fa fa-eye-slash togglePassword" id="togglePassword3"></i>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label form-control-label"></label>
                                            <div class="col-lg-9">
                                                <button class="btn btn--primary btn-block btn-lg" name="btn-Password" id="btn-Password" type="submit">Update </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- bodywrapper__inner end -->
            </div>
            <!-- body-wrapper end -->
            <script>
                const togglePassword4 = document.querySelector("#togglePassword1");
                const password4 = document.querySelector("#old-password");
                togglePassword4.addEventListener("click", function() {
                    // toggle the type attribute
                    const type = password4.getAttribute("type") === "password" ? "text" : "password";
                    password4.setAttribute("type", type);

                    // toggle the icon
                    this.classList.toggle("fa-eye");
                });
                const togglePassword5 = document.querySelector("#togglePassword2");
                const password5 = document.querySelector("#new-password");
                togglePassword5.addEventListener("click", function() {
                    // toggle the type attribute
                    const type = password5.getAttribute("type") === "password" ? "text" : "password";
                    password5.setAttribute("type", type);

                    // toggle the icon
                    this.classList.toggle("fa-eye");
                });
                const togglePassword6 = document.querySelector("#togglePassword3");
                const password6 = document.querySelector("#cnew-password");
                togglePassword6.addEventListener("click", function() {
                    // toggle the type attribute
                    const type = password6.getAttribute("type") === "password" ? "text" : "password";
                    password6.setAttribute("type", type);

                    // toggle the icon
                    this.classList.toggle("fa-eye");
                });
                
            </script>
            <?php include('inc/footer.php') ?>