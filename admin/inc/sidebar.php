<div class="sidebar capsule--rounded bg_img overlay--indigo overlay--opacity-8" data-background="assets/admin/images/sidebar/2.jpg">
                <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
                <div class="sidebar__inner">
                    <div class="sidebar__logo">
                        <a href="dashboard.php" class="sidebar__main-logo">Admin</a>

                        <a href="dashboard.php" class="sidebar__logo-shape">Admin</a>

                        <button type="button" class="navbar__expand"></button>
                    </div>

                    <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
                        <ul class="sidebar__menu">
                            <li class="sidebar-menu-item <?php if($page=='dashboard'){ echo 'active'; }  ?>">
                                <a href="dashboard.php" class="nav-link">
                                    <i class="menu-icon las la-home"></i>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item sidebar-dropdown <?php if($page1=='product'){ echo 'active'; }  ?> <?php if($page1=='product'){ echo 'sidebar-submenu__open'; }  ?>">
                                <a href="javascript:void(0)" class="">
                                    <i class="menu-icon la la-html5"></i>
                                    <span class="menu-title">Manage Product</span>
                                </a>
                                <div class="sidebar-submenu <?php if($page1=='product'){ echo 'sidebar-submenu__open'; }  ?>"  style="<?php if($page1=='product'){ echo 'display: block'; }else{ echo 'display: none';  }  ?>;">
                                    <ul>
                                        <li class="sidebar-menu-item <?php if($page=='product-add'){ echo 'active'; } ?>">
                                            <a href="product-add.php" class="nav-link">
                                                <i class="menu-icon las la-dot-circle"></i>
                                                <span class="menu-title">Add Product</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item <?php if($page=='all-product'){ echo 'active'; } ?>">
                                            <a href="product.php" class="nav-link">
                                                <i class="menu-icon las la-dot-circle"></i>
                                                <span class="menu-title">All Product</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                            <li class="sidebar-menu-item <?php if($page=='category'){ echo 'active'; }  ?>">
                                <a href="category.php" class="nav-link">
                                    <i class="menu-icon las la-tags"></i>
                                    <span class="menu-title">Category</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php if($page=='brand'){ echo 'active'; }  ?>">
                                <a href="brand.php" class="nav-link">
                                    <i class="menu-icon las la-copyright"></i>
                                    <span class="menu-title">Brand</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php if($page=='slider'){ echo 'active'; }  ?>">
                                <a href="slider.php" class="nav-link">
                                    <i class="menu-icon las la-home"></i>
                                    <span class="menu-title">Slider</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php if($page=='general-setting'){ echo 'active'; }  ?>">
                                <a href="general-setting.php" class="nav-link">
                                    <i class="menu-icon las la-life-ring"></i>
                                    <span class="menu-title">General Setting</span>
                                </a>
                            </li>
                    </div>
                </div>
            </div>