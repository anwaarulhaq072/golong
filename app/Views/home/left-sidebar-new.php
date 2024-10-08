<div class="sidebar">
    <a href="<?php echo base_url(); ?>/home/profile" class="profile">
        <img src="<?php echo ($_SESSION['user_data']['profile_img'] && $_SESSION['user_data']['profile_img'] !== '') ? base_url() . $_SESSION['user_data']['profile_img'] : base_url() . '/assets/images/users/user-1.jpg'; ?>" alt="profile-image" class="profile__img">
    </a>
    <div class="sidebar-list-holder">
        <?php  $requestUri = $_SERVER['REQUEST_URI']; ?>
        <ul class="sidebar-list sidebar-list1">
            <li class="sidebar-list__item">
                <a href="<?= base_url(); ?>" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'dashboard') || strpos($requestUri, 'customerdetails') || strpos($requestUri, 'userDashboardNew') || strpos($requestUri, 'report_genrate?userid') || strpos($requestUri, 'admin_tax_form') ) echo 'active';?>" id="dashboard">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/dashboard.svg" alt="" class="sidebar-list__icon hide-on-light">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/dashboard-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                </a>
            </li>
            <?php if ($_SESSION['user_data']['userTypeId'] == '2') : ?>
                <li class="sidebar-list__item">
                    <a href="<?= base_url(); ?>/user/deposit" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'deposit') ||  strpos($requestUri, 'add_deposit') ) echo 'active';?>" id="deposite">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/wallet.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/wallet-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar-list__item">
                    <a href="<?= base_url(); ?>/user/withdrawal" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'withdrawal') ||  strpos($requestUri, 'add_withdrawal') ) echo 'active';?>" id="withdrawal">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/withdrawal.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/withdrawal-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar_colour">
                    <a href="<?= base_url(); ?>/user/chat" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'chat') ) echo 'active';?>" id="chat">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/chat.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/chat-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar_colour">
                    <a href="<?= base_url(); ?>/user/overview" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'overview') ) echo 'active';?>" id="archive-history">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/archive-history.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/archive-history-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar_colour">
                    <a href="<?= base_url(); ?>/user/report_genrate" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'report_genrate') ) echo 'active';?>" id="statements">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/statements.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/statements-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
            <?php endif; ?>
            <li class="sidebar-list__item">
                <a href="<?= base_url(); ?>/home/profile" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'profile') ) echo 'active';?>"  id="account">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/user.svg" alt="" class="sidebar-list__icon hide-on-light">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/user-dark.svg" alt="" class="sidebar-list__icon hide-on-dark">
                </a>
            </li>
            <li class="sidebar-list__item">
                <?php if ($_SESSION['user_data']['userTypeId'] == '1') : ?>
                    <a href="<?= base_url(); ?>/admin/notifications" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'notifications') || strpos($requestUri, 'updatenotification') || strpos($requestUri, 'addnotification') ) echo 'active';?>" id="notification">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/bell.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/bell-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                <?php else: ?>
                    <a href="<?= base_url(); ?>/user/notifications" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'notifications') ) echo 'active';?>" id="notification">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/bell.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/bell-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                <?php endif; ?>

            </li>
            <?php if ($_SESSION['user_data']['userTypeId'] == '1') : ?>
                <li class="sidebar-list__item">
                    <a href="<?= base_url(); ?>/admin/deposit_requests" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'deposit_requests') ) echo 'active';?>" id="deposite">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/wallet.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/wallet-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar-list__item">
                    <a href="<?= base_url(); ?>/admin/withdrawal_requests" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'withdrawal_requests') ) echo 'active';?>" id="withdrawal">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/withdrawal.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/withdrawal-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar-list__item">
                    <a href="<?= base_url(); ?>/admin/createuser" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'createuser') ) echo 'active';?>" id="add-user">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/user-plus.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/user-plus-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar-list__item">
                    <a href="<?= base_url(); ?>/admin/bulkUpdate" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'bulkUpdate') ) echo 'active';?>" id="update-bulk-record">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/update.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/update-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="sidebar-list">
            <li class="sidebar-list__item">
            <div class="sidebar-list__link flex-a trn-all" id="light">
              <img src="<?php echo base_url(); ?>/assets-new/images/icons/light.svg" alt="" class="sidebar-list__icon">
            </div> 
            </li>
            <li class="sidebar-list__item">
                <div class="sidebar-list__link flex-a trn-all" id="dark">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/night.svg" alt="" class="sidebar-list__icon hide-on-light">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/night-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                </div>
            </li>
            <li class="sidebar-list__item">
                <a href="<?= base_url(); ?>/home/logout" class="sidebar-list__link flex-a trn-all" id="logout">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/logout.svg" alt="" class="sidebar-list__icon hide-on-light">
                    <img src="<?php echo base_url(); ?>/assets-new/images/icons/logout-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                </a>
            </li>
        </ul>
    </div>
</div>