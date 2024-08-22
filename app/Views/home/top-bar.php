<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* @media screen and (max-width: 768px) {
            .top_bar {
                margin-left: 0px !important;
            }
        }
        @media screen and (min-width: 769px) {
            .top_bar {
                margin-left: 240px !important;
            }
        } */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Poppins", sans-serif;
}

.container {
  max-width: 1050px;
  width: 90%;
  margin: auto;
}

.navbar {
  width: 100%;
  box-shadow: 0 1px 4px rgb(146 161 176 / 15%);
  z-index: 10;
  position: fixed;
  margin-top: -15px;
  margin-left: -6px;
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 62px;
}

.navbar .menu-items {
  display: flex;
  background: #0073B6;
}

.navbar .nav-container li {
  list-style: none;
}

.navbar .nav-container a {
  text-decoration: none;
  color: #0e2431;
  font-weight: 500;
  font-size: 1.2rem;
  padding: 0.7rem;
}

.navbar .nav-container a:hover{
    font-weight: bolder;
}

.nav-container {
  display: block;
  position: relative;
  height: 60px;
}

.nav-container .checkbox {
  position: absolute;
  display: block;
  height: 32px;
  width: 32px;
  top: 20px;
  left: 20px;
  z-index: 5;
  opacity: 0;
  cursor: pointer;
}

.nav-container .hamburger-lines {
  display: block;
  height: 26px;
  width: 32px;
  position: absolute;
  top: 17px;
  left: 20px;
  z-index: 2;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.nav-container .hamburger-lines .line {
  display: block;
  height: 4px;
  width: 100%;
  border-radius: 10px;
  background: #0e2431;
}

.nav-container .hamburger-lines .line1 {
  transform-origin: 0% 0%;
  transition: transform 0.4s ease-in-out;
}

.nav-container .hamburger-lines .line2 {
  transition: transform 0.2s ease-in-out;
}

.nav-container .hamburger-lines .line3 {
  transform-origin: 0% 100%;
  transition: transform 0.4s ease-in-out;
}

.navbar .menu-items {
  padding-top: 120px;
  /* box-shadow: inset 0 0 2000px rgba(255, 255, 255, .5); */
  height: 100vh;
  transform: translate(-150%);
  display: flex;
  flex-direction: column;
  margin-left: -40px;
  padding-left: 50px;
  transition: transform 0.5s ease-in-out;
  /* text-align: center; */
  width: 80%;
    text-align: start;
}

.navbar .menu-items li {
  margin-bottom: 1.2rem;
  font-size: 1.5rem;
  font-weight: 500;
}

.nav-container input[type="checkbox"]:checked ~ .menu-items {
  transform: translateX(0);
}

.nav-container input[type="checkbox"]:checked ~ .hamburger-lines .line1 {
  transform: rotate(45deg);
}

.nav-container input[type="checkbox"]:checked ~ .hamburger-lines .line2 {
  transform: scaleY(0);
}

.nav-container input[type="checkbox"]:checked ~ .hamburger-lines .line3 {
  transform: rotate(-45deg);
}
.sidebar_colour_for_mobile a {
            color: #FFFFFF66 !important;
        }

        .sidebar_colour_for_mobile :hover {
            color: #FFFFFF !important;
        }
        .sidebar_colour_for_mobile:hover .png_hover {
            opacity: 1 !important;
        }
        .png_hover{
            opacity: 0.5;
        }
        @media only screen and (max-width: 991px) {
            .nav-container .hamburger-lines {
        background: #F5F5FC;
        width: 100%;
        height: 126%;
        margin-left: -50px;
        margin-top: -19px;
        }
        }

        /*@media only screen and (min-width: 992px) {*/
        /*    .nav-container .hamburger-lines .line {*/
        /*    display: none !important;*/
        /*}*/
        /*}*/
        @media only screen and (min-width: 992px) {
            .nav-container{
            display: none !important;
        }
        }
        #alert_counter{
            display: inline-block;
            position: absolute;
            top: 16px;
            right: 10px;
        }
    </style>
</head>

<body>
    <input class="base_url" type="hidden" value="<?php echo base_url()?>">
    <input class="" id="usertype" type="hidden" value="<?php echo $_SESSION['user_data']['userTypeId'] ?>">
    <!-- Topbar Start -->
    <div class="navbar-custom top_bar" style="margin-left: 240px; background-color: #F5F5FC !important; box-shadow: none !important">
        <div class="container-fluid">
            <ul class="list-unstyled topnav-menu float-end mb-0">
                <?php if (isset($notification) && $_SESSION['user_data']['userTypeId'] == '2' && $_SESSION['user_data']['tax_form_flag']  == "Yes") : ?>
                    <li class="dropdown notification-list topbar-dropdown" id="notificationIcon">
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <?php if (isset($viewall) && $viewall == 'Y') : ?>
                            <?php elseif (isset($admin) && $admin == 'Y') :  ?>
                                <!-- <i class="fe-bell noti-icon" id="bellIcon"></i>
                                <span class="badge bg-danger rounded-circle noti-icon-badge" id="bellCount"><?php //echo sizeof($notification); 
                                                                                                            ?></span> -->
                            <?php else : ?>
                                <i class="fe-bell noti-icon" ></i>
                                <?php $count = 0;
                                    foreach($notification as $single){
                                        if($single['is_read'] == 'N'){
                                            $count++;
                                        }
                                } ?>
                                <span class="badge bg-danger rounded-circle noti-icon-badge" id="notificationcount"><?=  $count; ?></span>
                                <?php // if($count > 0): ?>
                                    <!-- <span class="badge bg-danger rounded-circle noti-icon-badge" id="notificationcount"><?=  $count; ?></span> -->
                                <?php //endif; ?>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-end">
                                        <!-- <a href="" class="text-dark">
                                    <small>Clear All</small>
                                </a> -->
                                    </span>Notifications
                                </h5>
                            </div>

                            <div class="noti-scroll" data-simplebar>
                                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                                <input type="hidden" id="userid" value="<?php if (isset($notification[0]['user_id'])) {
                                                                            echo $notification[0]['user_id'];
                                                                        } ?>">
                                <?php $i = 0;
                                while ($i < 10 && isset($notification[$i])) : ?>
                                    <a href="<?php echo base_url(); ?>/user/notifications" class="dropdown-item notify-item ">
                                        <div class="notify-icon bg-dark">
                                        <i class='fe-bell noti-icon'></i>
                                        </div>
                                        <p class="notify-details"><?php echo $notification[$i]['title']; ?>
                                            <small class="text-muted"><?php echo date('M d, Y', strtotime($notification[$i]['publishDate'])); ?></small>
                                        </p>
                                    </a>
                                    <?php $i++; ?>
                                <?php endwhile; ?>
                            </div>
                            <!-- All-->
                            <a href="<?php echo base_url(); ?>/user/notifications" class="dropdown-item text-center notify-item notify-all">
                                View all
                                <i class="fe-arrow-right"></i>
                            </a>

                        </div>
                    </li>
                <?php endif; ?>

                <?php if($_SESSION['user_data']['userTypeId'] == '1') : ?>
                    <li class="dropdown d-none d-lg-inline-block">
                        <a  class="nav-link dropdown-toggle arrow-none waves-effect waves-light" href="<?php echo base_url(); ?>/admin/createuser">
                            <button class="btn btn-primary" style="background-color: #0073B6; border-radius:10px; border: 1px solid #0073B6;">Create New User</button>
                        </a>                    
                    </li>
                    <li class="dropdown notification-list topbar-dropdown" id="adminNotificationIcon">
                        <a class="nav-link dropdown-toggle waves-effect waves-light"  data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-bell noti-icon" ></i>
                            <?php 
                                $count = 0;
                                if(isset($notification)){
                                    foreach($notification as $single){
                                        if($single['is_read'] == 'N'){
                                            $count++;
                                        }
                                    }
                                } 
                            ?>
                            <span class="badge bg-danger rounded-circle noti-icon-badge" id="alert_counter"><?=  $count; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg">

                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-end">
                                        <!-- <a href="" class="text-dark">
                                    <small>Clear All</small>
                                </a> -->
                                    </span>Notifications
                                </h5>
                            </div>

                            <div class="noti-scroll admin_alert" data-simplebar>
                                <!-- <input type="hidden" id="baseurl" value="<?php //echo base_url(); ?>"> -->
                                <input type="hidden" id="adminid" value="<?php if (isset($notification[0]['user_id'])) {
                                                                           echo $notification[0]['user_id'];
                                                                        } ?>">
                                <?php $i = 0;
                                while ($i < 10 && isset($notification[$i])) : 
                                $check = substr_count($notification[$i]['title'], 'Withdrawal');?>
                                 <?php if(isset($notification[$i]['title']) && $notification[$i]['title'] != NULL): ?>
                                   <?php  if($check >= 1){ ?>
                                        <a href="<?php echo base_url(); ?>/admin/withdrawal" class="dropdown-item notify-item ">
                                            <div class="notify-icon bg-dark" >
                                                <i class="fe-bell noti-icon"></i>
                                            </div>
                                            <p class="notify-details"><?php echo $notification[$i]['title']; ?>
                                                <small class="text-muted"><?php echo date('M d, Y', strtotime($notification[$i]['publishDate'])); ?></small>
                                            </p>
                                        </a>
                                    <?php }else{?>
                                        <a href="<?php echo base_url(); ?>/admin/deposit" class="dropdown-item notify-item ">
                                            <div class="notify-icon bg-dark" >
                                                <i class="fe-bell noti-icon"></i>
                                            </div>
                                            <p class="notify-details"><?php echo $notification[$i]['title']; ?>
                                                <small class="text-muted"><?php echo date('M d, Y', strtotime($notification[$i]['publishDate'])); ?></small>
                                            </p>
                                        </a>
                                    <?php }?>
                                    <?php endif; ?>
                                    <?php $i++; ?>
                                <?php endwhile; ?>
                            </div>
                            <!-- All-->
                            <a href="<?php echo base_url(); ?>/admin/alerts" class="dropdown-item text-center notify-item notify-all">
                                View all
                                <i class="fe-arrow-right"></i>
                            </a>

                        </div>
                        <?php endif; ?>
                    </li>
                <li class="dropdown d-inline-block d-lg-none">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="fe-search noti-icon"></i>
                    </a>
                    <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                        <form class="p-3">
                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                        </form>
                    </div>
                </li>

                <li class="dropdown d-none d-lg-inline-block">
                    <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                        <i class="fe-maximize noti-icon"></i>
                    </a>
                </li>

                <li class="dropdown notification-list topbar-dropdown">
                    <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="<?php echo ($_SESSION['user_data']['profile_img'] && $_SESSION['user_data']['profile_img']!=='') ? base_url().$_SESSION['user_data']['profile_img'] : base_url().'/assets/images/users/user-1.jpg';?>" alt="profile-image" class="rounded-circle">
                        <span class="pro-user-name ms-1">
                            <?php if ($_SESSION['user_data']['firstName'] == 'Admin') :  ?>
                                <?php session_start();
                                echo $_SESSION['user_data']['firstName'] ?> <i class="mdi mdi-chevron-down"></i>
                            <?php elseif($_SESSION['user_data']['userTypeId'] == '1') : ?>
                                <?php session_start();
                                echo $_SESSION['user_data']['firstName'] . " " . $_SESSION['user_data']['lastName']; ?> <i class="mdi mdi-chevron-down"></i>
                                </br><p style="margin: -50px 0px 0px 0px; font-size:11px; color: rgba(0, 0, 0, 0.3);">Admin</p>
                            <?php else : ?>
                                <?php session_start();
                                echo $_SESSION['user_data']['firstName'] . " " . $_SESSION['user_data']['lastName']; ?> <i class="mdi mdi-chevron-down"></i>
                            <?php endif; ?>
                        </span>
                        <input type="hidden" id="userid" value="<?php echo ($_SESSION['user_data']['id']); ?>">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <?php if($_SESSION['user_data']['tax_form_flag'] == "Yes"): ?>
                        <a href="<?php echo base_url(); ?>/home/profile" class="dropdown-item notify-item">
                            <i class="fe-user"></i>
                            <span>My Account</span>
                        </a>
                        <?php endif; ?>

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <!-- <a href="javascript:void(0);" class="dropdown-item notify-item"> -->
                        <?php if (isset($superadminid) && $superadminid == 3) : ?>
                            <a href="<?php echo base_url(); ?>/home/superadminlogin" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo base_url(); ?>/home/logout" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </li>

            </ul>


            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">

                <li>
                    <!-- Mobile menu toggle (Horizontal Layout)-->
                    <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>

                <li class="dropdown d-none d-lg-inline-block">
                    <button class="primary_btn" style="margin: 15px 0px 0px 25px; padding: 7px 18px 9px 18px; border-radius:10px;"><img src="<?=base_url();?>/assets/images/calendar.png"> </i> &nbsp; &nbsp; <b> <?=date('d M Y'); ?></b></button>
                </li>

                <!-- <li class="dropdown d-none d-xl-block">

                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <?php session_start();
                        if ($_SESSION['user_data']['userTypeId'] == '1') : ?>
                            Create New
                        <?php else : ?>
                            Welcome To Dashboard
                        <?php endif; ?>
                        <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <?php // session_start(); ?>
                     <?php // if ($_SESSION['user_data']['userTypeId'] == '1') : ?>
                        <div class="dropdown-menu">

                            <a href="<?php echo base_url(); ?>/admin/createuser" class="dropdown-item">
                                <i class="fe-user me-1"></i>
                                <span>User</span>
                            </a>

                            <a href="<?php echo base_url(); ?>/admin/notifications" class="dropdown-item">
                                <i class="fe-bell me-1"></i>
                                <span>Notification</span>
                            </a>
                            <a href="<?php echo base_url(); ?>/admin/bulkUpdate" class="dropdown-item">
                                <i class="fe-book-open me-1"></i>
                                <span>Update Bulk Records</span>
                            </a>
                        </div>
                    <?php // endif; ?>
                </li> -->

            </ul>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- end Topbar -->
    <nav>
      <div class="navbar">
        <div class="container nav-container">
            <input style="color: white;" class="checkbox" type="checkbox" name="" id="" />
            <div class="hamburger-lines box_slash" >
              <span style="width: 44px; margin-top: 20px; margin-left: 40px;" class="line line1"></span>
              <span style="width: 44px; margin-left: 40px;" class="line line2"></span>
              <span style="width: 44px; margin-left: 40px; margin-bottom: 22px;" class="line line3"></span>
            </div>  
          <div class="menu-items">
          <ul id="side-menu" style="margin-top:70px; margin: 0px -65px">
                    <?php session_start(); ?>
                    <li class="sidebar_colour_for_mobile">
                        <a href="<?= base_url(); ?>" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/dashboard' || strtok($_SERVER['REQUEST_URI'], '?') == '/admin/customerdetails' || strtok($_SERVER['REQUEST_URI'], '?') == '/admin/userDashboard'){ echo "color: white !important";} ?>">
                            <i class="fa fa-qrcode"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    <?php if ($_SESSION['user_data']['userTypeId'] == '2') : ?>
                        <li class="sidebar_colour_for_mobile">
                            <a href="<?= base_url(); ?>/user/deposit" style="<?php if($_SERVER['REQUEST_URI'] == '/user/deposit'){ echo "color: white !important";} ?>">
                            <i>
                                <img src="<?= base_url(); ?>/assets/images/deposit.png" alt="Deposit" width="20" class="png_hover">
                            </i>
                                <span> Deposit</span>
                            </a>
                        </li>
                        <li class="sidebar_colour_for_mobile">
                            <a href="<?= base_url(); ?>/user/withdrawal" style="<?php if($_SERVER['REQUEST_URI'] == '/user/withdrawal'){ echo "color: white !important";} ?>">
                            <i>
                                <img src="<?= base_url(); ?>/assets/images/withdrawal.png" alt="Withdrawal" width="20" class="png_hover">
                            </i>
                                <span> Withdrawal </span>
                            </a>
                        </li>
                        <li class="sidebar_colour_for_mobile">
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
                    <li class="sidebar_colour_for_mobile">
                        <a href="<?= base_url(); ?>/home/profile" style="<?php if($_SERVER['REQUEST_URI'] == '/home/profile'){ echo "color: white !important";} ?>">
                            <i class="fa fa-user"></i>
                            <span> Account </span>
                        </a>
                    </li>
                    
                    <li class="sidebar_colour_for_mobile">
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
                        <li class="sidebar_colour_for_mobile">
                            <a href="<?= base_url(); ?>/admin/deposit_requests" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/deposit_requests'){ echo "color: white !important";} ?>">
                                <i>
                                    <img src="<?= base_url(); ?>/assets/images/deposit.png" alt="Deposit" width="20" class="png_hover">
                                </i>
                                <span> Deposit </span>
                            </a>
                        </li>
                        <li class="sidebar_colour_for_mobile">
                            <a href="<?= base_url(); ?>/admin/withdrawal_requests" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/withdrawal_requests'){ echo "color: white !important";} ?>">
                                <i>
                                    <img src="<?= base_url(); ?>/assets/images/withdrawal.png" alt="Withdrawal" width="20" class="png_hover">
                                </i>
                                <span> Withdrawal </span>
                            </a>
                        </li>
                        <li class="sidebar_colour_for_mobile">
                            <a href="<?= base_url(); ?>/admin/createuser" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/createuser'){ echo "color: white !important";} ?>">
                                <i class="fa fa-user-plus"></i>
                                <span> Add User </span>
                            </a>
                        </li>
                        <li class="sidebar_colour_for_mobile">
                            <a href="<?= base_url(); ?>/admin/bulkUpdate" style="<?php if($_SERVER['REQUEST_URI'] == '/admin/bulkUpdate'){ echo "color: white !important";} ?>">
                                <i class="fa fa-recycle"></i>
                                <span> Update Bulk record </span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="sidebar_colour_for_mobile">
                        <a href="<?= base_url(); ?>/home/logout">
                            <img src="<?= base_url(); ?>/assets/images/carbon_logout.png" alt="logout">
                            <span> Logout </span>
                        </a>
                    </li>
                </ul>
          </div>
        </div>
      </div>
    </nav>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/notificationModal.js"></script>
</body>

</html>