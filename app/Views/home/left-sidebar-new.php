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
            <li class="sidebar-list__item">
            <!--<li class="sidebar_colour">-->
            <!--    <?php if ($_SESSION['user_data']['userTypeId'] == '1') : ?>-->
            <!--            <a href="<?= base_url(); ?>/admin/uploaded_documents" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'uploaded_documents') || strpos($requestUri, 'uploaded_documents') || strpos($requestUri, 'uploaded_documents') ) echo 'active';?>" id="uploaded_documents">-->
            <!--            <img src="<?php echo base_url(); ?>/assets-new/images/icons/statements.svg" alt="" class="sidebar-list__icon hide-on-light">-->
            <!--            <img src="<?php echo base_url(); ?>/assets-new/images/icons/statements-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">-->
            <!--        </a>-->
            <!--    <?php else: ?>-->
            <!--            <a href="<?= base_url(); ?>/user/upload_documents" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'upload_documents') ) echo 'active';?>" id="upload_documents">-->
            <!--            <img src="<?php echo base_url(); ?>/assets-new/images/icons/statements.svg" alt="" class="sidebar-list__icon hide-on-light">-->
            <!--            <img src="<?php echo base_url(); ?>/assets-new/images/icons/statements-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">-->
            <!--        </a>-->
            <!--    <?php endif; ?>-->
            <!--</li>-->
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
                    <a href="<?= base_url(); ?>/admin/chat" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'chat') ) echo 'active';?>" id="chat">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/chat.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/chat-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
                    </a>
                </li>
                <li class="sidebar-list__item">
                    <a href="<?= base_url(); ?>/admin/kyc_documents" class="sidebar-list__link flex-a trn-all <?php if (strpos($requestUri, 'kyc_documents') ) echo 'active';?>" id="kyc">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/kyc_form.svg" alt="" class="sidebar-list__icon hide-on-light">
                        <img src="<?php echo base_url(); ?>/assets-new/images/icons/kyc_form-brown.svg" alt="" class="sidebar-list__icon hide-on-dark">
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
            <div class="sidebar-list__link flex-a trn-all change_hover" id="wifi">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar-list__icon sidebar-list__icon2">
                    <path d="M12.0001 17C12.2653 17 12.5196 17.1054 12.7072 17.2929C12.8947 17.4804 13.0001 17.7348 13.0001 18C13.0001 18.2652 12.8947 18.5196 12.7072 18.7071C12.5196 18.8947 12.2653 19 12.0001 19C11.7348 19 11.4805 18.8947 11.2929 18.7071C11.1054 18.5196 11.0001 18.2652 11.0001 18C11.0001 17.7348 11.1054 17.4804 11.2929 17.2929C11.4805 17.1054 11.7348 17 12.0001 17ZM12.0001 13C13.3801 13 14.6321 13.56 15.5361 14.464C15.7237 14.6516 15.8291 14.9061 15.8291 15.1715C15.8291 15.4369 15.7237 15.6914 15.5361 15.879C15.3484 16.0666 15.0939 16.1721 14.8286 16.1721C14.5632 16.1721 14.3087 16.0666 14.1211 15.879C13.5586 15.3164 12.7956 15.0002 12.0001 15C11.1711 15 10.4231 15.335 9.87906 15.879C9.69141 16.0666 9.43692 16.1721 9.17156 16.1721C8.90619 16.1721 8.6517 16.0666 8.46406 15.879C8.27641 15.6914 8.171 15.4369 8.171 15.1715C8.171 14.9061 8.27641 14.6516 8.46406 14.464C8.92844 13.9997 9.47973 13.6315 10.0864 13.3803C10.6932 13.1291 11.3434 12.9999 12.0001 13ZM12.0001 9.00001C13.1821 8.99891 14.3528 9.23119 15.4449 9.68354C16.5369 10.1359 17.529 10.7994 18.3641 11.636C18.5462 11.8246 18.647 12.0772 18.6447 12.3394C18.6425 12.6016 18.5373 12.8524 18.3519 13.0378C18.1665 13.2232 17.9157 13.3284 17.6535 13.3307C17.3913 13.333 17.1387 13.2322 16.9501 13.05C16.3007 12.3991 15.5291 11.883 14.6796 11.5312C13.8301 11.1794 12.9195 10.9989 12.0001 11C11.0806 10.9989 10.17 11.1794 9.32053 11.5312C8.47106 11.883 7.69946 12.3991 7.05006 13.05C6.86145 13.2322 6.60885 13.333 6.34665 13.3307C6.08446 13.3284 5.83365 13.2232 5.64824 13.0378C5.46283 12.8524 5.35766 12.6016 5.35538 12.3394C5.3531 12.0772 5.4539 11.8246 5.63606 11.636C6.47113 10.7994 7.46317 10.1359 8.55526 9.68354C9.64734 9.23119 10.818 8.99891 12.0001 9.00001ZM12.0001 5.00001C15.5901 5.00001 18.8401 6.45601 21.1921 8.80801C21.3742 8.99661 21.475 9.24921 21.4727 9.51141C21.4705 9.77361 21.3653 10.0244 21.1799 10.2098C20.9945 10.3952 20.7437 10.5004 20.4815 10.5027C20.2193 10.505 19.9667 10.4042 19.7781 10.222C18.758 9.19878 17.5456 8.38735 16.2108 7.83439C14.8759 7.28144 13.4449 6.99787 12.0001 7.00001C10.5552 6.99787 9.1242 7.28144 7.78935 7.83439C6.45449 8.38735 5.24215 9.19878 4.22206 10.222C4.03345 10.4042 3.78085 10.505 3.51865 10.5027C3.25646 10.5004 3.00565 10.3952 2.82024 10.2098C2.63483 10.0244 2.52966 9.77361 2.52738 9.51141C2.5251 9.24921 2.6259 8.99661 2.80806 8.80801C4.01382 7.59905 5.44661 6.64028 7.02407 5.98677C8.60153 5.33327 10.2926 4.99793 12.0001 5.00001Z" fill="#fff"/>
                </svg>
            </div> 
            </li>
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