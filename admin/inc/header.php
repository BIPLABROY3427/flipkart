<!-- meta tags and other links -->
<?php include('function.php');
if(isset($_SESSION['ID'])==true){
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" />
        <!-- bootstrap 4  -->
        <link rel="stylesheet" href="assets/admin/css/vendor/grid.min.css" />
        <!-- bootstrap toggle css -->
        <link rel="stylesheet" href="assets/admin/css/vendor/bootstrap-toggle.min.css" />
        <!-- fontawesome 5  -->
        <link rel="stylesheet" href="assets/global/css/all.min.css" />
        <!-- line-awesome webfont -->
        <link rel="stylesheet" href="assets/global/css/line-awesome.min.css" />
        <!-- custom select box css -->
        <link rel="stylesheet" href="assets/admin/css/vendor/nice-select.css" />
        <!-- dashdoard main css -->
        <link rel="stylesheet" href="assets/admin/css/app.css" />
        <link rel="stylesheet" href="assets/DataTables/datatables.css" />
        <script src="assets/global/js/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        
        
    </head>
    <body>
        <!-- page-wrapper start -->
        <div class="page-wrapper default-version">
        <nav class="navbar-wrapper">
                <form class="navbar-search" onsubmit="return false;">
                    <button type="submit" class="navbar-search__btn">
                        <i class="las la-search"></i>
                    </button>
                    <input type="search" name="navbar-search__field" id="navbar-search__field" placeholder="Search..." />
                    <button type="button" class="navbar-search__close"><i class="las la-times"></i></button>

                    <div id="navbar_search_result_area">
                        <ul class="navbar_search_result"></ul>
                    </div>
                </form>

                <div class="navbar__left">
                    <button class="res-sidebar-open-btn"><i class="las la-bars"></i></button>
                    <button type="button" class="fullscreen-btn">
                        <i class="fullscreen-open las la-compress" onclick="openFullscreen();"></i>
                        <i class="fullscreen-close las la-compress-arrows-alt" onclick="closeFullscreen();"></i>
                    </button>
                </div>

                <div class="navbar__right">
                    <ul class="navbar__action-list">

                        <li class="dropdown">
                            <button type="button" class="" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                <span class="navbar-user">
                                    <span class="navbar-user__thumb"><img src="<?php echo PROFILE_PATH.$get_admin['image']; ?>" alt="image" /></span>
                                    <span class="navbar-user__info">
                                        <span class="navbar-user__name"><?php echo $get_admin['username']; ?></span>
                                    </span>
                                    <span class="icon"><i class="las la-chevron-circle-down"></i></span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu--sm p-0 border-0 box--shadow1 dropdown-menu-right">
                                <a href="profile.php" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                    <i class="dropdown-menu__icon las la-user-circle"></i>
                                    <span class="dropdown-menu__caption">Profile</span>
                                </a>

                                <a href="profile.php" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                    <i class="dropdown-menu__icon las la-key"></i>
                                    <span class="dropdown-menu__caption">Password</span>
                                </a>

                                <a href="logout.php" class="dropdown-menu__item d-flex align-items-center px-3 py-2">
                                    <i class="dropdown-menu__icon las la-sign-out-alt"></i>
                                    <span class="dropdown-menu__caption">Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <?php } ?>
           