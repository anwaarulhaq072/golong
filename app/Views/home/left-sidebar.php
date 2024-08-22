<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .sidebar_colour a {
            color: #FFFFFF66 !important;
        }

        .sidebar_colour :hover {
            color: #FFFFFF !important;
        }
        .sidebar_colour:hover .png_hover {
            opacity: 1 !important;
        }
        .png_hover{
            opacity: 0.5;
        }
    </style>
</head>

<body>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu" style="background-color: #0073B6 !important; top:0px !important;">

        <div class="h-100" data-simplebar>
            <!--- Sidemenu -->
            <div id="sidebar-menu">


                <!-- LOGO -->
                <div class="logo-box" style="float:none; height: auto;">
                    <a href="<?php echo base_url(); ?>" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="<?php echo base_url(); ?>/assets/images/logo_white.png" alt="" height="70">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url(); ?>/assets/images/logo_white.png" alt="" height="100">
                            <!-- <span class="logo-lg-text-light">U</span> -->
                        </span>
                    </a>

                    <a href="<?php echo base_url(); ?>" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="<?php echo base_url(); ?>/assets/images/logo_white.png" alt="" height="70">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo base_url(); ?>/assets/images/logo_white.png" alt="" height="100">
                        </span>
                    </a>
                </div>


                <ul id="side-menu" style="margin-top:70px;">
                    <?php session_start(); ?>
                    <li class="sidebar_colour">
                        <a href="<?= base_url(); ?>" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/dashboard' || strtok($_SERVER['REQUEST_URI'], '?') == '/admin/customerdetails' || strtok($_SERVER['REQUEST_URI'], '?') == '/admin/userDashboard'){ echo "color: white !important";} ?>">
                            <i class="fa fa-qrcode"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <?php if ($_SESSION['user_data']['userTypeId'] == '2') : ?>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/user/deposit" style="<?php if($_SERVER['REQUEST_URI'] == '/user/deposit'){ echo "color: white !important";} ?>">
                            <i>
                                <img src="<?= base_url(); ?>/assets/images/deposit.png" alt="Deposit" width="20" class="png_hover">
                            </i>
                                <span> Deposit </span>
                            </a>
                        </li>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/user/withdrawal" style="<?php if($_SERVER['REQUEST_URI'] == '/user/withdrawal'){ echo "color: white !important";} ?>">
                            <i>
                                <img src="<?= base_url(); ?>/assets/images/withdrawal.png" alt="Withdrawal" width="20" class="png_hover">
                            </i>
                                <span> Withdrawal </span>
                            </a>
                        </li>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/user/chat" style="<?php if($_SERVER['REQUEST_URI'] == '/user/chat'){ echo "color: white !important";} ?>">
                                <i class="fa fa-comments"></i>
                                <span> Chat </span>
                            </a>
                        </li>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/user/overview" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/bulkUpdate'){ echo "color: white !important";} ?>">
                                <i class="fa fa-book"></i>
                                <span> Archive History </span>
                            </a>
                        </li>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/user/report_genrate" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/bulkUpdate'){ echo "color: white !important";} ?>">
                                <i class="fa fa-file" aria-hidden="true"></i>
                                <span> Statements </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="sidebar_colour">
                        <a href="<?= base_url(); ?>/home/profile" style="<?php if($_SERVER['REQUEST_URI'] == '/home/profile'){ echo "color: white !important";} ?>">
                            <i class="fa fa-user"></i>
                            <span> Account </span>
                        </a>
                    </li>
                    
                    <li class="sidebar_colour">
                        <?php if ($_SESSION['user_data']['userTypeId'] == '1') : ?>
                            <a href="<?= base_url(); ?>/admin/notifications" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/notifications'){ echo "color: white !important";} ?>">
                                <i class="fa fa-bell"></i>
                                <span> Notification </span>
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url(); ?>/user/notifications" style="<?php if($_SERVER['REQUEST_URI'] == '/user/notifications'){ echo "color: white !important";} ?>">
                                <i class="fa fa-bell"></i>
                                <span> Notification </span>
                            </a>
                        <?php endif; ?>
                    </li>
                    <?php if ($_SESSION['user_data']['userTypeId'] == '1') : ?>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/admin/deposit_requests" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/deposit_requests'){ echo "color: white !important";} ?>">
                                <i>
                                    <img src="<?= base_url(); ?>/assets/images/deposit.png" alt="Deposit" width="20" class="png_hover">
                                </i>
                                <span> Deposit </span>
                            </a>
                        </li>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/admin/withdrawal_requests" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/withdrawal_requests'){ echo "color: white !important";} ?>">
                                <i>
                                    <img src="<?= base_url(); ?>/assets/images/withdrawal.png" alt="Withdrawal" width="20" class="png_hover">
                                </i>
                                <span> Withdrawal </span>
                            </a>
                        </li>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/admin/createuser" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/createuser'){ echo "color: white !important";} ?>">
                                <i class="fa fa-user-plus"></i>
                                <span> Add User </span>
                            </a>
                        </li>
                        <li class="sidebar_colour">
                            <a href="<?= base_url(); ?>/admin/bulkUpdate" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/bulkUpdate'){ echo "color: white !important";} ?>">
                                <i class="fa fa-recycle"></i>
                                <span> Update Bulk record </span>
                            </a>
                        </li>
                    <?php endif; ?>
                   
                    <li class="sidebar_colour">
                        <a href="<?= base_url(); ?>/home/logout">
                            <img src="<?= base_url(); ?>/assets/images/carbon_logout.png" alt="logout">
                            <span> Logout </span>
                        </a>
                    </li>
                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->


</body>

</html>